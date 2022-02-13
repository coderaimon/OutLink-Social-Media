// document.addEventListener("contextmenu", function(e){
//     e.preventDefault();
// }, false);

// preview post image

var input = document.getElementById("post_img");
input.addEventListener("change", preview);

function preview() {
  var fileobj = this.files[0];
  var filereader = new FileReader();
  filereader.readAsDataURL(fileobj);
  filereader.onload = function () {
    var img_src = filereader.result;
    var image = document.getElementById("pre_img");
    image.setAttribute("src", img_src);
    image.setAttribute("style", "display:");
  };
}

// srinking post text
function tsrink(text) {
  var posttext = document.getElementById(text);
  var pttoggle = posttext.classList.toggle("t");
  if (pttoggle == true) {
    posttext.classList.remove("text-truncate");
  } else {
    posttext.classList.add("text-truncate");
  }
}

// follow suggested user
$(".folbtn").click(function () {
  var us_id = $(this).data("userId");
  $(this).attr("disabled", true);
  $(this).text("Followed");
  $(this).removeClass("folbtn");
  $(this).removeClass("btn-primary");
  $(this).addClass("btn-secondary");
  $.ajax({
    url: "assets/php/areq.php?follow",
    method: "post",
    datatype: "json",
    data: { user_id: us_id },
  });
});

// follow suggested user
$(".unfolbtn").click(function () {
  var us_id = $(this).data("userId");
  $(this).attr("disabled", true);
  $(this).text("Unfollowed");
  $(this).removeClass("unfolbtn");
  $(this).removeClass("btn-danger");
  $(this).addClass("btn-secondary");
  $.ajax({
    url: "assets/php/areq.php?unfollow",
    method: "post",
    datatype: "json",
    data: { user_id: us_id },
  });
});

// for like users posts
$(".like").click(function () {
  var post_id_v = $(this).data("postId");
  var user_id_v = $(this).data("userId");
  var button = this;
  $.ajax({
    url: "assets/php/areq.php?like",
    method: "post",
    datatype: "json",
    data: { user_id: user_id_v, post_id: post_id_v },
    success: function (response) {
      if (!response.status) {
        $(button).attr("class", "fas fa-heart unlike");
        location.reload();
      } else {
        alert("something went wrong!");
      }
    },
  });
});

// for unlike users posts
$(".unlike").click(function () {
  var post_id_v = $(this).data("postId");
  var button = this;
  $.ajax({
    url: "assets/php/areq.php?unlike",
    method: "post",
    datatype: "json",
    data: { post_id: post_id_v },
    success: function (response) {
      if (!response.status) {
        $(button).attr("class", "far fa-heart like");
        location.reload();
      } else {
        alert("something went wrong!");
      }
    },
  });
});

$(".unblock").click(function () {
  var us_id = $(this).data("userId");
  $(this).attr("class", "btn btn-secondary");
  $(this).text("Unblocked");
  window.location.reload()
  $.ajax({
    url: "assets/php/areq.php?unblock",
    method: "post",
    datatype: "json",
    data: { user_id: us_id },
    success: (response) => {
      console.log(response.status);
    },
  });
});