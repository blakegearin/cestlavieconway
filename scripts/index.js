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

function bin2board(bin) {
  let board = [];
  let gridSize = 20;


  for (let i = 0; i < bin.length; i = i + gridSize) {
    let row = bin.substr(i, gridSize).split("");
    board.push(row);
  }

  return board;
}

function bin2hex(bin) {
  let hex = "";
  let bitsInHex = 4;

  for (let i = 0; i < bin.length; i = i + bitsInHex) {
    let eightBits = bin.substr(i, bitsInHex);
    let currentHex = (parseInt(eightBits, 2)).toString(16).toUpperCase();
    hex += currentHex;
  }

  return hex;
}

function getBoardInBinary() {
  let board = readBoard();
  return board.flat().join("");
}

function getBoardInHex() {
  let binary = getBoardInBinary();
  return hex2bin(binary);
}

function setBoard(round, status, binary, hex) {
  if (round != null) {
    $("#round").text(round);
  }

  if (hex != null) {
    setBoardId(hex);
  }

  let board = bin2board(binary);
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

  if (status != null) {
    setStatus(status);
  }
}

function go() {
  let status = $("#status").text().toLowerCase();
  let deadOrStuck = ["dead", "stuck"].includes(status);
  let stopDisabled = $("#stop").is(":disabled");

  let stop = deadOrStuck || stopDisabled;

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
          let binary = response[2];
          let hex = response[3];
          setBoard(round, status, binary, hex);
          setTimeout(go, 5);
        }
      }
    );
  }
}

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
  let textTransparency = showText ? 1 : 0;
  let textColor = hexToRgb(textColorHex, textTransparency);

  let borderColorHex = $("#border-color")[0].value;
  let showBorder = $("#show-border")[0].checked;
  let borderTransparency = showBorder ? 1 : 0;
  let borderColor = hexToRgb(borderColorHex, borderTransparency);

  $.ajax(
    {
      type: "POST",
      url: "php/set_preference.php",
      data: {
        deadColor: deadColor,
        aliveColor: aliveColor,
        textColorHex: textColorHex,
        textColor: textColor,
        showText: showText,
        borderColorHex: borderColorHex,
        borderColor: borderColor,
        showBorder: showBorder
      },
      success: function(data) {}
    }
  );
}

function hex2bin(hex) {
  let bin = "";
  let bitsInHex = 4;

  Array.from(hex).forEach(
    function (char) {
      let currentBin = parseInt(char, 16).toString(2);

      if (currentBin.length < bitsInHex) {
        let padding = "0".repeat(bitsInHex-currentBin.length);
        currentBin = padding + currentBin;
      }

      bin += currentBin;
    }
  );

  return bin;
}

$(function() {
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
            let binary = response[2];
            let hex = response[3];
            setBoard(round, status, binary, hex);
          }
        }
      );
    }
  });

  $("#reset").click(function() {
    $("#stop").prop("disabled", true);
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
          let binary = response[2];
          let hex = response[3];
          setBoard(round, status, binary, hex);
        }
      }
    );
  });

  $("#clear").click(function() {
    $("#stop").prop("disabled", true);
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
          let binary = response[2];
          let hex = response[3];
          setBoard(round, status, binary, hex);
        }
      }
    );
  });

  $("#dead-color, #alive-color").change(function() {
    $(`.${this.id.replace("-color", "")}`).css("background-color", this.value);

    setPreferences();
  });

  $("#text-color").change(function() {
    let transparency = $("#show-text").prop("checked") ? 1 : 0;
    $(".content").css("color", hexToRgb(this.value, transparency));

    setPreferences();
  });

  $("#border-color").change(function() {
    let transparency = $("#show-border").prop("checked") ? 1 : 0;
    let borderColor = hexToRgb(this.value, transparency);

    let checked = $("#show-border").prop("checked");
    if (checked) {
      $(".table-border-color").css("border", `1px ${borderColor} solid`);
    }

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

    $(".content").css("color", newColor);
    setPreferences();
  });

  $("#show-border").click(function() {
    let currentBorder = $(".table-border-color").css("border");
    let newBorder = "";

    let checked = $("#show-border").prop("checked");
    if (checked) {
      let borderColor = hexToRgb($("#border-color")[0].value, 1);
      newBorder = `1px ${borderColor} solid`;
    } else {
      newBorder = "none";
    }

    $(".table-border-color").css("border", newBorder);
    setPreferences();
  });

  $("#hex").bind('input propertychange', function() {
    let value = this.value;
    let length = value.length;
    let currentColor = $(this).css("background-color");

    let errorColor = "rgb(251, 176, 176)";
    let hexSymbols = new RegExp("[^a-f|^A-F|^0-9]");

    if (length != 100) {
      $(this).css("background-color", errorColor);
      $("#hex-error").text("Please enter 100 characters.");

      if (currentColor != errorColor) {
        $("#hex-error").show();
      }
    } else if (hexSymbols.test(value)) {
      $(this).css("background-color", errorColor);
      $("#hex-error").text("Please enter hexadecimal symbols (0-9 or A-F).");

      if (currentColor != errorColor) {
        $("#hex-error").show();
      }
    } else {
      $(this).css("background-color", "white");
      $("#hex-error").hide();
      setBoard(null, null, hex2bin(value), null);
    }
  });

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
