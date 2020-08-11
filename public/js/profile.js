window.onload = onLoadActions();

function onLoadActions(){
	checkIfSeniorChecked();
	checkIfSpecialNeedsChecked();
}

function checkIfSeniorChecked(){
    if(document.getElementById('juniorInput').checked) {
      removeSeniorInput();
			displaySameGenderAllocOption();
    }else if(document.getElementById('seniorInput').checked) {
      displaySeniorInput();
			removeSameGenderAllocOption();
    }
}

function displaySeniorInput(){
  document.getElementById("seniorChoice").style.display = "flex";
}

function removeSeniorInput(){
  document.getElementById("seniorChoice").style.display = "none";
}

function checkIfSpecialNeedsChecked(){
    if(document.getElementById('spcialNeedsInput').checked) {
      displaySpecialNeedsInput();
    }else {
      removeSpecialNeedsInput();
    }
}

function removeSpecialNeedsInput(){
  document.getElementById("special_needs_textbox").style.display = "none";
}

function displaySpecialNeedsInput(){
  document.getElementById("special_needs_textbox").style.display = "flex";
}

function removeSameGenderAllocOption(){
  document.getElementById("sameGenderAlloc").style.display = "none";
}

function displaySameGenderAllocOption(){
  document.getElementById("sameGenderAlloc").style.display = "flex";
}
