function removeMultipeSelectorIfSuperAdmin(){
  if($("#cmb_role").val()=="manager"){
    document.getElementById("multiple_selector").style.display = "none";
    document.getElementById("cmb_entitlement").style.display = "none";
  }else{
    document.getElementById("multiple_selector").style.display = "flex";
    document.getElementById("cmb_entitlement").style.display = "flex";
  }
}
removeMultipeSelectorIfSuperAdmin();
