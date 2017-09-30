var canvas = document.getElementById('canv'),
    ctx = canvas.getContext('2d');


var generateImg = function (txt, id, color) {
    var text = txt.split("\n").join("\n");
    var text = txt;
    var x = 12.5;
    var y = 15;
    var lineheight = 30;
    var lines = text.split('\n');
    var lineLengthOrder = lines.slice(0).sort(function (a, b) {
        return b.length - a.length;
    });
    ctx.canvas.width = ctx.measureText(lineLengthOrder[0]).width + 25;
    ctx.canvas.height = (lines.length * lineheight);
    ctx.fillStyle = "transparent";
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    ctx.textBaseline = "middle";
    ctx.font = "20px Anonymous Pro";
    if (color)
        ctx.fillStyle = color;
    else
        ctx.fillStyle = "#676767";

    for (var i = 0; i < lines.length; i++)
        ctx.fillText(lines[i], x, y + (i * lineheight));
    // document.getElementById(id).src = ctx.canvas.toDataURL();
    $(id).attr('src', ctx.canvas.toDataURL());
}

generateImg('', '#imgCanvas');

// generateImg('', 'image1');
// generateImg(decodeURIComponent(escape(atob('Q2VjaSBlc3QgdW5lIGNoYcOubmUgZW5jb2TDqWU='))), 'image1');
// generateImg('Maher Ben Sassi', 'image2');
// generateImg('test', 'image3');