window.addEventListener("app:mounted",(function(){var e=document.querySelector("#monochromeToggle");e.addEventListener("change",(function(){return $monochromemode.toggle()})),window.addEventListener("change:monochrome",(function(n){e.checked="monochrome"===n.detail.currentMode}))}),{once:!0});