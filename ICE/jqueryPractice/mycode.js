$(document).ready(function() {
  //as soon as html is loaded below will happen
  //hide p tags
  $("p").hide();
  //if click on h1, do something
  $("h1").click(function() {
    //toggles visibility of tags after heading tag
    $(this).next().slideToggle(300);
  })
});