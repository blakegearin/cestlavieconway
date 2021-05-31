function setStatus(text) {
  text = text.charAt(0).toUpperCase() + text.slice(1);
  $("#status").text(text);
}

function updateCell(element, updateHex) {
  let content = $(element);
  content.toggleClass("alive");
  content.toggleClass("dead");

  let type = content.hasClass("alive") ? "alive" : "dead";
  setStatus("alive");

  if (type === "alive") {
    $(element).css("background-color", $("#alive-color")[0].value);
    $(element).text(1);
  } else {
    $(element).css("background-color", $("#dead-color")[0].value);
    $(element).text(0);
  }

  if (updateHex) {
    let hex = getBoardInHex();
    setBoardId(hex);
  }
}

function readBoard() {
  let board = [];
  let rows = $("#game-table tr");

  for (let r = 0; r < rows.length; r++) {
    let row = [];
    let columns = $(rows[r]).find(".content");

    for (let c = 0; c < columns.length; c++) {
      let column = columns[c];
      let value = parseInt($(column)[0].innerHTML);
      row.push(value);
    }
    board.push(row);
  }

  return board;
}

function setBoardId(hex) {
  let hexString = hex.match(/.{1,25}/g).join("<br>");
  let hexElement = $("#hex");

  hexElement.text("");
  hexElement.append(hexString);
}

function getBoardInHex() {
  let board = readBoard();
  let binary = board.flat().join("");

  let hex = "";
  let count = 0;
  for (let i = 0; i < binary.length; i = i + 4) {
    count++
    let eightBits = binary.substr(i, 4);
    let newHex = (parseInt(eightBits, 2)).toString(16).toUpperCase();
    hex = hex + newHex;
  }
  return hex;
}

function setBoard(round, status, board, hex) {
  $("#round").text(round);
  setBoardId(hex);

  let rows = $("#game-table tr");

  for (let r = 0; r < rows.length; r++) {
    let columns = $(rows[r]).find(".content");

    for (let c = 0; c < columns.length; c++) {
      let value = parseInt(board[r][c]);
      let cell = $(`#r${r}c${c}`);
      if (parseInt(cell.text()) !== value) {
        updateCell(cell, false);
      }
    }
  }

  setStatus(status);
}

function checkStop() {
  let status = $("#status").text().toLowerCase();
  let deadOrStuck = ["dead", "stuck"].includes(status);
  let stopDisabled = $("#stop").is(":disabled");

  return deadOrStuck || stopDisabled;
}

function go() {
  let stop = checkStop();

  if (stop) {
    $("#go").prop("disabled", false);
    $("#stop").prop("disabled", true);
    $("#next").prop("disabled", false);
  } else {
    $.ajax(
      {
        type: "POST",
        url: "php/update_board.php",
        data: {
          board: readBoard()
        },
        success: function(data) {
          let response = JSON.parse(data);
          let round = response[0];
          let status = response[1];
          let board = response[2];
          let hex = response[3];
          setBoard(round, status, board, hex);
          setTimeout(go, 5);
        }
      }
    );
  }
}

$("#go").click(function() {
  $(this).prop("disabled", true);
  $("#stop").prop("disabled", false);
  $("#next").prop("disabled", true);
  go();
});

$("#stop").click(function() {
  $(this).prop("disabled", this);
  $("#go").prop("disabled", false);
});

$("#next").click(function() {
  $("#go").prop("disabled", false);
  let status = $("#status").text().toLowerCase();
  let stop = ["dead", "stuck"].includes(status);
  if (!stop) {
    $.ajax(
      {
        type: "POST",
        url: "php/update_board.php",
        data: {
          board: readBoard()
        },
        success: function(data) {
          let response = JSON.parse(data);
          let round = response[0];
          let status = response[1];
          let board = response[2];
          let hex = response[3];
          setBoard(round, status, board, hex);
        }
      }
    );
  }
});

$("#reset").click(function() {
  $("#go").prop("disabled", false);

  $.ajax(
    {
      type: "POST",
      url: "php/reset_board.php",
      data: {
        board: readBoard()
      },
      success: function(data) {
        let response = JSON.parse(data);
        let round = response[0];
        let status = response[1];
        let board = response[2];
        let hex = response[3];
        setBoard(round, status, board, hex);
      }
    }
  );
});

$("#clear").click(function() {
  $("#go").prop("disabled", false);

  $.ajax(
    {
      type: "POST",
      url: "php/clear_board.php",
      data: {
        board: readBoard()
      },
      success: function(data) {
        let response = JSON.parse(data);
        let round = response[0];
        let status = response[1];
        let board = response[2];
        let hex = response[3];
        setBoard(round, status, board, hex);
      }
    }
  );
});

$("#dead-color, #alive-color").change(function() {
  $(`.${this.id.replace("-color", "")}`).css("background-color", this.value);
  setPreferences();
});

function hexToRgb(hex, transparency) {
  var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
  let r = parseInt(result[1], 16);
  let g = parseInt(result[2], 16);
  let b = parseInt(result[3], 16);
  return `rgba(${r}, ${g}, ${b}, ${transparency})`
}

function setPreferences() {
  let deadColor = $("#dead-color")[0].value;
  let aliveColor = $("#alive-color")[0].value;

  let textColorHex = $("#text-color")[0].value;
  let showText = $("#show-text")[0].checked;
  let transparency = showText ? 1 : 0;
  let textColor = hexToRgb(textColorHex, transparency);

  $.ajax(
    {
      type: "POST",
      url: "php/set_preference.php",
      data: {
        deadColor: deadColor,
        aliveColor: aliveColor,
        textColorHex: textColorHex,
        textColor: textColor,
        showText: showText
      },
      success: function(data) {
        // console.dir(data);
      }
    }
  );
}

$("#text-color").change(function() {
  let transparency = $("#show-text").prop("checked") ? 1 : 0;
  $(".content").css("color", hexToRgb(this.value, transparency));
  setPreferences();
});

$("#show-text").click(function() {
  let currentColor = $(".content").css("color");
  let newColor = "";

  let checked = $("#show-text").prop("checked");
  if (checked) {
    newColor = currentColor.substring(0, currentColor.length - 4) + `, 1)`;
  } else {
    newColor = currentColor.substring(0, currentColor.length - 1) + `, 0)`;
  }

  $(".content").css("color", newColor)
  setPreferences();
});


// Credit: https://stackoverflow.com/a/2014138/5988852
$(function() {
  var isMouseDown = false, isHighlighted;
  $("#game-table .content").mousedown(function() {
    isMouseDown = true;
    updateCell(this, true);
    return false; // Prevent text selection
  })
  .mouseover(function() {
    if (isMouseDown) {
      updateCell(this, true);
    }
  })
  .bind("selectstart", function() {
    return false;
  })

  $(document).mouseup(function() {
    isMouseDown = false;
  });
});

$('#switch-toggle-all [data-toggle-all]' ).click(function () {
  $( '#switch-toggle-all input[type="checkbox"]').prop('checked', this.checked)
})
