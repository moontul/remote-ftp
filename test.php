<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, height=device-height">
</head>

<body>
<div class="frame">
<span class="thread"></span>
<div class="holder">
<div class="part-1"></div>
<span class="part-2-wrap"><div class="part-2"></div></span>
<span class="part-3-wrap"><div class="part-3"></div></span>
<span class="part-4-wrap"><div class="part-4"></div></span>
<div class="part-5"></div>
<span class="part-6-wrap"><div class="part-6"></div></span>
<span class="part-7-wrap"><div class="part-7"></div></span>
</div>
</div>

</body>
</html>

<style>
* {
  box-sizing: border-box;
}

body {
  background: #f1f1f1;
  display: flex;
  align-items: center;
  flex-direction: column;
}

.frame {
  width: 65vw;
  height: 65vw;
  border-radius: 50%;
  border: 5px solid white;
  box-shadow: 1px 1px 13px 2px #5d5d5d30;
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
  overflow: hidden;
  transform: translateY(3vw);
  background-image: linear-gradient(to top, #fff1eb 0%, #ace0f9 100%);
}

.thread {
  width: 1px;
  height: 35vw;
  background: #80808061;
  position: absolute;
  left: 50%;
  top: 0;
  transform-origin: top;
}

.holder {
  width: 90%;
  height: 90%;
  position: relative;
  border-radius: 50%;
  animation: moveAll 3s ease-in-out 0s infinite alternate;
}

@keyframes moveAll {
  100% {
    transform: translateY(4vw);
  }
}
.part-1 {
  clip-path: polygon(0% 0%, 89% 0%, 64% 48%, -1% 71%);
  background: #c71d1d;
  width: 30vw;
  height: 25vw;
  position: absolute;
  top: 24vw;
  left: 26vw;
}

.part-2-wrap {
  filter: drop-shadow(9px 5px 10px rgba(0, 0, 0, 0.2)) drop-shadow(-9px 5px 10px rgba(0, 0, 0, 0.2));
  position: absolute;
  left: 0vw;
  top: 0vw;
  z-index: 6;
}

.part-2 {
  clip-path: polygon(21% 41%, 95% 56%, 100% 82%, 0% 92%);
  background: #e01c1c;
  background: #da1f1f;
  width: 23vw;
  height: 33vw;
  position: absolute;
  transform: rotate(344deg);
  left: 22vw;
  top: 8.6vw;
}

.part-3-wrap {
  filter: drop-shadow(-9px 0px 8px rgba(0, 0, 0, 0.3));
  position: absolute;
  left: 0vw;
  top: 0vw;
  z-index: 5;
}

.part-3 {
  background: #da1f1f;
  clip-path: polygon(40% 14%, 0% 100%, 100% 100%);
  width: 18vw;
  height: 22vw;
  position: absolute;
  left: 26.2vw;
  top: 2.6vw;
  z-index: 8;
  transform-origin: bottom;
  animation: fold-3 2s ease 0s infinite alternate;
}

@keyframes fold-3 {
  100% {
    transform: rotateX(38deg);
  }
}
.part-4-wrap {
  filter: drop-shadow(-8px 9px 12px rgba(0, 0, 0, 0.3));
  position: absolute;
  left: 0vw;
  top: 0vw;
  z-index: 3;
}

.part-4 {
  clip-path: polygon(100% 0, 46% 100%, 100% 84%);
  background: #d02020;
  width: 18vw;
  height: 25vw;
  position: absolute;
  top: 24vw;
  left: 8.3vw;
  z-index: 1;
}

.part-5 {
  clip-path: polygon(47% 0, 14% 52%, 83% 70%);
  background: linear-gradient(303deg, #c71d1d 50%, #000000 100%);
  width: 10vw;
  height: 10vw;
  position: absolute;
  top: 24vw;
  left: 47.98vw;
}

.part-6 {
  clip-path: polygon(100% 16%, 0% 5%, 100% 100%);
  background: #cf2020;
  width: 20vw;
  height: 36vw;
  position: absolute;
  top: 0vw;
  left: 13.4vw;
  z-index: 2;
  transform-origin: bottom;
  animation: fold-1 2s ease 0s infinite alternate;
}

@keyframes fold-1 {
  100% {
    transform: rotateX(30deg);
  }
}
.part-6-wrap {
  filter: drop-shadow(-11px 21px 7px rgba(0, 0, 0, 0.3));
  position: absolute;
  left: 0vw;
  top: 0vw;
  z-index: 3;
}

.part-7-wrap {
  filter: drop-shadow(-13px 17px 11px rgba(0, 0, 0, 0.3));
  position: absolute;
  left: 0vw;
  top: 0vw;
  z-index: 2;
}

.part-7 {
  clip-path: polygon(100% 14%, 7% 4%, 89% 61%);
  background: #cf2020;
  background: linear-gradient(22deg, #c71d1d 60%, #000000 167%);
  width: 25vw;
  height: 31vw;
  position: absolute;
  top: 7vw;
  left: 6vw;
  transform-origin: bottom;
  animation: fold-2 2s ease 0s infinite alternate;
}

@keyframes fold-2 {
  100% {
    transform: rotateX(30deg);
  }
}
</style>
