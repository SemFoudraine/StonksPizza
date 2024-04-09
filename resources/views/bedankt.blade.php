<h1>PROGRESS BAR</h1>
<Style>
body {
  font-family: 'Roboto Condensed';
  height: 100vh;
  width: 100vw;
  padding: 0;
  background-image: radial-gradient(#051B23, shade(#051B23, 25));
}

h1 {
  color: #fcb034;
  text-align: center;
  font-size: 7vw;
  margin-top: 10vh;
  letter-spacing: 3px;
  position: absolute;
  width: 100%;
}

.icon {
  display: inline-block;
	width: 1.5em;
	height: 1.5em;
	fill: none;
}

.hidden {
  display: none;
}

.progress {
  display: flex;
  width: 100%;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%,-50%);
  margin: 0 0 0 10%;
}
.step {
  flex-grow: 1;
  position: relative;
}

.step-progress {
  width: 100%;
  height: 0.25em;
  background: #fcb034;
}
.icon-wrapper {
  text-align: center;
  display: inline-block;
}

.step.done .step-progress:after {
  position: absolute;
  content: '';
  height: 0.25em;
  width: 0;
  background-color: #0087B3;
  animation: growLine 1s linear forwards;
}

.icon-checkmark {
  position: absolute;
  top: -0.55em;
  left: -0.125em;
  border: 0.125em solid #fcb034;
  background: #051B23;
  width: 1em;
  height: 1em;
  border-radius: 50%;
  padding: 0.125em;
  border-radius: 50%;
  transition: all 0.25s linear;
}
.step.done .icon-checkmark {
  background: #0087B3;
  border-color: #0087B3;
}

.icon-checkmark .path1 {
  stroke: #aaa;
  stroke-width: 4;
  stroke-linecap: square;
  stroke-dasharray: 1000;
  stroke-dashoffset: 1000;
  fill: empty;
}
.step.done .icon-checkmark .path1 {
  animation: dash 5s linear forwards;
  stroke: #fcb034;
}

.step-text {
  position: relative;
  margin-left: -50%;
  letter-spacing: 1px;
  font-weight: bold;
  color: #aaa;
  margin-top: 0;
  opacity: 0;
}
.step.done .step-text {
  color: #0087B3;
  animation: dropText 0.5s linear forwards;
}

@keyframes dash {
  to {
    stroke-dashoffset: 0;
  }
}

@keyframes growLine {
  to {
    width: 100%;
  }
}

@keyframes dropText {
  to {
    padding-top: 1em;
    opacity: 1;
  }
}
</Style>
<section>
<div class="progress">
  <div class="step">
    <div class="step-progress"></div>
    <div class="icon-wrapper">
      <svg class="icon icon-checkmark" viewBox="0 0 32 32"><path class="path1" d="M27 4l-15 15-7-7-5 5 12 12 20-20z"></path>  </svg>
      <div class="step-text">ENROLLED</div>
    </div>
  </div>
  <div class="step">
    <div class="step-progress"></div>
    <div class="icon-wrapper">
      <svg class="icon icon-checkmark" viewBox="0 0 32 32"><path class="path1" d="M27 4l-15 15-7-7-5 5 12 12 20-20z"></path>  </svg>
      <div class="step-text">APPLIED</div>
    </div>
  </div>
  <div class="step">
    <div class="step-progress"></div>
    <div class="icon-wrapper">
      <svg class="icon icon-checkmark" viewBox="0 0 32 32"><path class="path1" d="M27 4l-15 15-7-7-5 5 12 12 20-20z"></path>  </svg>
      <div class="step-text">CONFIRMED</div>
    </div>
  </div>
  <div class="step">
    <div class="icon-wrapper">
      <svg class="icon icon-checkmark" viewBox="0 0 32 32"><path class="path1" d="M27 4l-15 15-7-7-5 5 12 12 20-20z"></path>  </svg>
      <div class="step-text">DONE!</div>
    </div>
  </div>
</div>

</section>

