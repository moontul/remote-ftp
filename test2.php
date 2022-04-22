<html>
<body>

    <script type="text/javascript">
        var canvas = document.body.appendChild(document.createElement("canvas"));
canvas.width = 610;
canvas.height = 787;
var ctx = canvas.getContext("2d");
var bgimg = (function() {
  var img = document.createElement("img");
  img.src = 'https://i.stack.imgur.com/XYThp.png';
  return img;
})();
canvas.onclick = function(evt) {
  console.log(evt.layerX - evt.target.offsetLeft, evt.layerY);
};
var Shape = (function() {
  function Shape(position, points) {
    if (points === void 0) {
      points = [];
    }
    this.position = position;
    this.points = points;
  }
  Shape.prototype.draw = function(ctx, str) {
    ctx.font = "14px Courier";
    var lineSize = ctx.measureText("i").width;
    var minY = this.points
      .map(function(a) {
        return a.y;
      })
      .sort(function(a, b) {
        return (a < b ? -1 : 1);
      })[0];
    var minX = this.points
      .map(function(a) {
        return a.x;
      })
      .sort(function(a, b) {
        return (a < b ? -1 : 1);
      })[0];
    var maxY = this.points
      .map(function(a) {
        return a.y;
      })
      .sort(function(a, b) {
        return (b < a ? -1 : 1);
      })[0];
    var maxX = this.points
      .map(function(a) {
        return a.x;
      })
      .sort(function(a, b) {
        return (b < a ? -1 : 1);
      })[0];
    ctx.fillStyle = "rgba(255,0,0,0.1)";
    for (var ai = 0; ai < this.points.length; ai++) {
      var a = this.points[ai];
      var b = this.points[(ai + 1) % this.points.length];
      if (ai === 0) {
        ctx.beginPath();
        ctx.moveTo(a.x + this.position.x, a.y + this.position.y);
      }
      ctx.lineTo(b.x + this.position.x, b.y + this.position.y);
    }
    ctx.closePath();
    ctx.fill();
    //ctx.textBaseline = "bottom";
    ctx.fillStyle = "black";
    var strLeft = str;
    var line = minY;
    while (line <= maxY && strLeft.length > 0) {
      var startX = null;
      var endX = null;
      for (var x = minX; x <= maxX; x += lineSize) {
        var data = ctx.getImageData(x + this.position.x, line + this.position.y, 1, 1).data;
        if (data[0] + data[1] + data[2] + data[3] > 0) {
          if (startX === null) {
            startX = x;
          } else {
            endX = x;
          }
        }
      }
      if (line == 398) {
        console.log(startX, endX);
      }
      var length = Math.floor((endX - startX) / lineSize);
      var localStr = strLeft.substr(0, length);
      strLeft = strLeft.substr(length);
      ctx.fillText(localStr, startX + this.position.x, line + this.position.y);
      line += lineSize + 2;
    }
    /*
    ctx.globalCompositeOperation = 'destination-over';
    ctx.drawImage(bgimg, 0, 0);
    ctx.globalCompositeOperation = 'source-over';
    */
  };
  return Shape;
}());
var shape = new Shape({
  x: 0,
  y: 0
}, [{
    x: 5,
    y: 104
  },
  {
    x: 125,
    y: 46
  },
  {
    x: 205,
    y: 50
  },
  {
    x: 254,
    y: 101
  },
  {
    x: 346,
    y: 180
  },
  {
    x: 398,
    y: 254
  },
  {
    x: 425,
    y: 290
  },
  {
    x: 462,
    y: 347
  },
  {
    x: 476,
    y: 414
  },
  {
    x: 485,
    y: 459
  },
  {
    x: 515,
    y: 546
  },
  {
    x: 524,
    y: 590
  },
  {
    x: 539,
    y: 634
  },
  {
    x: 572,
    y: 689
  },
  {
    x: 571,
    y: 712
  },
  {
    x: 567,
    y: 734
  },
  {
    x: 582,
    y: 777
  },
  {
    x: 557,
    y: 746
  },
  {
    x: 492,
    y: 744
  },
  {
    x: 489,
    y: 757
  },
  {
    x: 461,
    y: 757
  },
  {
    x: 349,
    y: 597
  },
  {
    x: 203,
    y: 537
  },
  {
    x: 130,
    y: 413
  },
  {
    x: 94,
    y: 312
  },
  {
    x: 93,
    y: 244
  },
  {
    x: 103,
    y: 198
  },
  {
    x: 105,
    y: 162
  },
  {
    x: 73,
    y: 124
  },
  {
    x: 36,
    y: 118
  },
]);
setTimeout(function() {
  shape.draw(ctx, "include file f there wondering, fearing,\nDoubting, dreaming dreams no mortal ever dared to dream before;\nBut the silence was unbroken, and the stillness gave no token,\nAnd the only word there spoken was the whispered word, \u201CLenore?\u201D\nThis I whispered, and an echo murmured back the word, \u201CLenore!\u201D\u2014\nMerely this and nothing more.\n\nBack into the chamber turning, all my soul within me burning,\nSoon again I heard a tapping somewhat louder than before.\n\u201CSurely,\u201D said I, \u201Csurely that is something at my window lattice;\nLet me see, then, what thereat is, and this mystery explore\u2014\nLet my heart be still a moment and this mystery explore;\u2014\n\u2019Tis the wind and nothing more!\u201D\n\nOpen here I flung the shutter, when, with many a flirt and flutter,\nIn there stepped a stately Raven of the saintly days of yore;\nNot the least obeisance made he; not a minute stopped or stayed he;\nBut, with mien of lord or lady, perched above my chamber door\u2014\nPerched upon a bust of Pallas just above my chamber door\u2014\nPerched, and sat, and nothing more.\n\nThen this ebony bird beguiling my sad fancy into smiling,\nBy the grave and stern decorum of the countenance it wore,\n\u201CThough thy crest be shorn and shaven, thou,\u201D I said, \u201Cart sure no craven,\nGhastly grim and ancient Raven wandering from the Nightly shore\u2014\nTell me what thy lordly name is on the Night\u2019s Plutonian shore!\u201D\nQuoth the Raven \u201CNevermore.\u201D\n\nMuch I marvelled this ungainly fowl to hear discourse so plainly,\nThough its answer little meaning\u2014little relevancy bore;\nFor we cannot help agreeing that no living human being\nEver yet was blessed with seeing bird above his chamber door\u2014\nBird or beast upon the sculptured bust above his chamber door,\nWith such name as \u201CNevermore.\u201D\n\nBut the Raven, sitting lonely on the placid bust, spoke only\nThat one word, as if his soul in that one word he did outpour.\nNothing farther then he uttered\u2014not a feather then he fluttered\u2014\nTill I scarcely more than muttered \u201COther friends have flown before\u2014\nOn the morrow he will leave me, as my Hopes have flown before.\u201D\nThen the bird said \u201CNevermore.\u201D\n\nStartled at the stillness broken by reply so aptly spoken,\n\u201CDoubtless,\u201D said I, \u201Cwhat it utters is its only stock and store\nCaught from some unhappy master whom unmerciful Disaster\nFollowed fast and followed faster till his songs one burden bore\u2014\nTill the dirges of his Hope that melancholy burden bore\nOf \u2018Never\u2014nevermore\u2019.\u201D\n\nBut the Raven still beguiling all my fancy into smiling,\nStraight I wheeled a cushioned seat in front of bird, and bust and door;\nThen, upon the velvet sinking, I betook myself to linking\nFancy unto fancy, thinking what this ominous bird of yore\u2014\nWhat this grim, ungainly, ghastly, gaunt, and ominous bird of yore\nMeant in croaking \u201CNevermore.\u201D\n\nThis I sat engaged in guessing, but no syllable expressing\nTo the fowl whose fiery eyes now burned into my bosom\u2019s core;\nThis and more I sat divining, with my head at ease reclining\nOn the cushion\u2019s velvet lining that the lamp-light gloated o\u2019er,\nBut whose velvet-violet lining with the lamp-light gloating o\u2019er,\nShe shall press, ah, nevermore!\n\nThen, methought, the air grew denser, perfumed from an unseen censer\nSwung by Seraphim whose foot-falls tinkled on the tufted floor.\n\u201CWretch,\u201D I cried, \u201Cthy God hath lent thee\u2014by these angels he hath sent thee\nRespite\u2014respite and nepenthe from thy memories of Lenore;\nQuaff, oh quaff this kind nepenthe and forget this lost Lenore!\u201D\nQuoth the Raven \u201CNevermore.\u201D\n\n\u201CProphet!\u201D said I, \u201Cthing of evil!\u2014prophet still, if bird or devil!\u2014\nWhether Tempter sent, or whether tempest tossed thee here ashore,\nDesolate yet all undaunted, on this desert land enchanted\u2014\nOn this home by Horror haunted\u2014tell me truly, I implore\u2014\nIs there\u2014is there balm in Gilead?\u2014tell me\u2014tell me, I implore!\u201D\nQuoth the Raven \u201CNevermore.\u201D\n\n\u201CProphet!\u201D said I, \u201Cthing of evil!\u2014prophet still, if bird or devil!\nBy that Heaven that bends above us\u2014by that God we both adore\u2014\nTell this soul with sorrow laden if, within the distant Aidenn,\nIt shall clasp a sainted maiden whom the angels name Lenore\u2014\nClasp a rare and radiant maiden whom the angels name Lenore.\u201D\nQuoth the Raven \u201CNevermore.\u201D\n\n\u201CBe that word our sign of parting, bird or fiend!\u201D I shrieked, upstarting\u2014\n\u201CGet thee back into the tempest and the Night\u2019s Plutonian shore!\nLeave no black plume as a token of that lie thy soul hath spoken!\nLeave my loneliness unbroken!\u2014quit the bust above my door!\nTake thy beak from out my heart, and take thy form from off my door!\u201D\nQuoth the Raven \u201CNevermore.\u201D\n\nAnd the Raven, never flitting, still is sitting, still is sitting\nOn the pallid bust of Pallas just above my chamber door;\nAnd his eyes have all the seeming of a demon\u2019s that is dreaming,\nAnd the lamp-light o\u2019er him streaming throws his shadow on the floor;\nAnd my soul from out that shadow that lies floating on the floor\nShall be lifted\u2014nevermore!");
}, 100);
    </script><canvas width="610" height="787"></canvas>

<div class="as-console-wrapper" style="display: block;"><div class="as-console"><div class="as-console-row" data-date="03:53:06.892">
  <code class="as-console-row-code">568 357</code></div></div></div><script type="module" charset="UTF-8" src="chrome-extension://aefibgbaijilanbphdomgjlogkldhlpm/framework/bootstrap/content/content-loader.js"></script><script type="text/javascript" charset="UTF-8" src="chrome-extension://aefibgbaijilanbphdomgjlogkldhlpm/vendor/crypto/aes.js"></script><script type="text/javascript" charset="UTF-8" src="chrome-extension://aefibgbaijilanbphdomgjlogkldhlpm/vendor/crypto/pad-zeropadding-min.js"></script>
</body>
