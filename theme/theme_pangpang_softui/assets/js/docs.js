$(function(){
  var navbarToggler = document.getElementsByClassName("ct-docs-navbar-toggler")[0];

  if(navbarToggler){
      navbarToggler.addEventListener("click", function() {
        var sidebarCollapseLinks = document.getElementsByClassName("ct-docs-sidebar-collapse-links")[0];
        if(sidebarCollapseLinks){
                  var sidebarcol = document.getElementsByClassName("ct-docs-sidebar-col")[0];

                  if (sidebarCollapseLinks.style.maxHeight) {
                    sidebarCollapseLinks.style.maxHeight = null;
                    sidebarCollapseLinks.style.padding = null;
                    sidebarCollapseLinks.style.display = null;
                    sidebarcol.style.display="none";
                  } else {

                    sidebarcol.style.display="block";
                    sidebarCollapseLinks.style.display = "block";
                    // the 48 is for the padding heights as well
                    // 2rem + 1rem = 3rem = 3 * 16 px = 48px
                    sidebarCollapseLinks.style.maxHeight = sidebarCollapseLinks.scrollHeight + 48 + "px";
                    sidebarCollapseLinks.style.padding = "2rem 0 1rem";
                  }
          }
      })
  }
  // navbar dropdowns init
  let dropdowns = document.getElementsByClassName("ct-docs-nav-item-dropdown");
  for (var i = 0; i < dropdowns.length; i++) {
    dropdowns[i].addEventListener("mouseenter", dropdownEvent);
    dropdowns[i].addEventListener("mouseleave", dropdownEvent);
  }
  function dropdownEvent(event) {
    let currentEventTarget = event.currentTarget;
    let dropdownMenu = currentEventTarget.getElementsByClassName("ct-docs-navbar-dropdown-menu")[0];
    if(dropdownMenu.classList.contains("ct-docs-navbar-dropdown-menu-show")) {
      dropdownMenu.style.display = null;
      dropdownMenu.classList.remove("ct-docs-navbar-dropdown-menu-show");
    } else {
      dropdownMenu.style.display = "block";
      dropdownMenu.classList.add("ct-docs-navbar-dropdown-menu-show");
    }
  }
});

function chk_pp_sidebar(){

    if($(".ct-docs-sidebar-col").attr("class")){
      if($(".navbar-togger-main").css("display")=="block"){
        $(".ct-docs-navbar-toggler").removeClass("d-none");
      }
    }else{
      //$(".ct-docs-navbar-toggler").css("visibility","hidden");
    }

  if (matchMedia("screen and (min-width: 768px)").matches) {
    // 000px 이상에서 사용할 JavaScript
    $(".pp-sidebar").addClass("show");
    var sidebarcol = document.getElementsByClassName("ct-docs-sidebar-col")[0];
    if(sidebarcol){
      sidebarcol.style.display = "block";
    }
  } else {
    // 000px 미만에서 사용할 JavaScript
    if($(".pp-sidebar").length){
      $(".pp-sidebar").removeClass("show");
    }else{
      console.log("-----없음---");
      $("#toggler-pp-sidebar").hide();
    }

    var sidebarcol = document.getElementsByClassName("ct-docs-sidebar-col")[0];
    if(sidebarcol){
      sidebarcol.style.display = "none";
    }
  }

  $(".pp-adm-btns").css("right","50px");
}

$(window).resize(function() {chk_pp_sidebar();});
$(function(){
  chk_pp_sidebar();
})
  chk_pp_sidebar();
