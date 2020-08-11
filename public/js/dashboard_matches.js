window.onload = showMatchmakingButton();

function showMatchmakingButton()
{
  if(document.getElementById("cmb").value=="all"){
    document.getElementById("match_students").style.display="none";
  }else{
    document.getElementById("match_students").style.visibility="visible";
  }
}

function clickFilterButton()
{
  document.getElementById('show_matches').click();
} 



