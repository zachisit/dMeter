function countUp(current) {
  current += 1
  $('#counter').html(current)
  setTimeout(function(){countUp(current)}, 1000);
}

$(document).ready(function() {
  setTimeout(function(){countUp($foo)}, 1000);
});