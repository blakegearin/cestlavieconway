function updateCell(element) {
  let td = $(element);
  td.toggleClass("alive");
  td.toggleClass("dead");
  let type = td.hasClass("alive") ? "alive" : "dead";

  if (type === "alive") {
    $(element).css("background-color", $("#alive")[0].value);
    $(element).text(1);
  } else {
    $(element).css("background-color", $("#dead")[0].value);
    $(element).text(0);
  }
}

function readBoard() {
  let board = [];
  let rows = $("#myTable tr");

  for (let r = 0; r < rows.length; r++) {
    let row = [];
    let columns = $(rows[r]).find("td");

    for (let c = 0; c < columns.length; c++) {
      let column = columns[c];
      let value = parseInt($(column)[0].innerHTML);
      row.push(value);
    }
    board.push(row);
  }

  return board;
}

function setBoard(board) {
  let rows = $("#myTable tr");

  for (let r = 0; r < rows.length; r++) {
    let columns = $(rows[r]).find("td");

    for (let c = 0; c < columns.length; c++) {
      let value = parseInt(board[r][c]);
      let cell = $(`#r${r}c${c}`);
      if (parseInt(cell.text()) !== value) {
        updateCell(cell);
      }
    }
  }
}

$('#go').click(function() {
  $.ajax(
    {
      type: "POST",
      url: "generate_board.php",
      data: {
        board: readBoard()
      },
      success: function(data) {
        // console.log(data);
        let board = JSON.parse(data);
        // console.dir(board);
        // console.log(board[0][[0]]);
        setBoard(board);
      }
    }
  );
  // .done(
  //   function(msg) {
  //     console.log("Data Saved: " + msg);
  //   }
  // );
});

$("#reset").click(function() {
  $("table td").removeClass("alive");
  $("table td").addClass("dead");
  $("table td").css("background-color", $("#dead")[0].value);
  $("table td").text(0);
});

$("#dead, #alive").change(function() {
  $(`.${this.id}`).css("background-color", this.value);
});

// Credit: https://stackoverflow.com/a/2014138/5988852
$(function() {
  var isMouseDown = false, isHighlighted;
  $("#myTable td").mousedown(function() {
    isMouseDown = true;
    updateCell(this);
    return false; // Prevent text selection
  })
  .mouseover(function() {
    if (isMouseDown) {
      updateCell(this);
    }
  })
  .bind("selectstart", function() {
    return false;
  })

  $(document).mouseup(function() {
    isMouseDown = false;
  });
});
