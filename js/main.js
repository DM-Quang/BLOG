console.log("main js loaded");
// get needed elements
let theform = document.querySelector("form.comment-form");
let thecomment = document.querySelector(".comment-form textarea");
let hiddeninput = document.querySelector(".comment-form input");
let commentsdiv = document.querySelector(".comments_before");
let commentcard = document.querySelectorAll(".card");

// add event listener, prevent default submission and get
//textarea value

theform.addEventListener("submit", function(event) {
  event.preventDefault();
  let comment = thecomment.value;
  let postid = hiddeninput.value.split("=");
  let theaction = "function/ajaxmanager.php";
  commentAjax(comment, postid[1], theaction)
  theform.reset();
})

commentcard.forEach((card, i) => {
  card.addEventListener("click", function(e) {
    e.preventDefault();
    console.log("click");
    if(e.target.classList.contains("delete-comment")){
      console.log("delete");
      let par = e.target.parentNode.parentNode.parentNode;
      console.log(par);
      par.classList.add("shrinkStart");
      setTimeout(function(){
        par.classList.add("shrinkFinish");
      },100);
    }

    console.log(e);
  })

});


// ajax request

function commentAjax(comment, postid, theaction) {

  let xhr = new XMLHttpRequest();
  xhr.open("POST", theaction, true);
  // to use the post method we must set the request headers
  // depending on the form data being sent
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onload = function() {
    if(this.status == 200) {
        console.log(this);
        let new_comment = JSON.parse(this.responseText);
        outputNewComment(new_comment);
    }
  }

  xhr.send("comment="+comment+"&post_id="+postid);
}

// General function
function outputNewComment(output) {
  
  let theoutput = `
  <div class="col-md-6 offset-md-3 mt-2 mb-2">
    <div class="card">
      <div class="card-header">
      ${output.user_name} | ${output.date_created}  
      <a href='#' data-comment-number='{$comment['comment_id']}'><button class='delete-comment float-right btn btn-outline-danger btn-sm'>X</button></a>                           
      </div>
      <div class="card-body">
        <p class="card-text">${output.comment_text}</p>
      </div>
    </div>
  </div>`;

  commentsdiv.insertAdjacentHTML("beforebegin", theoutput);

}
