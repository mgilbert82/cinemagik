/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import "./styles/app.css";

class App {
  constructor() {
    this.handleCommentForm();
  }

  handleCommentForm() {
    const commentForm = document.querySelector("form.comment-form");

    if (commentForm === null) return;

    commentForm.addEventListener(
      "submit",
      this.handleSubmit.bind(this)
    );
  }

  async handleSubmit(e) {
    e.preventDefault();

    const res = await fetch("/ajax/comment", {
      method: "POST",
      body: new FormData(e.target),
    });

    if (!res.ok) return;

    const json = await res.json();

    if (json.code === "COMMENT_ADDED_SUCCESSFULLY") {
      const elementsToUpdate = {
        commentList: document.querySelector(".comment-list"),
        commentCount: document.querySelector("#comment_count"),
        commentMessage: document.querySelector("#comment_message"),
      };

      this.updateElements(
        elementsToUpdate,
        json.message,
        json.numberOfComments
      );
    }
  }

  updateElements(elements, message, numberOfComments) {
    elements.commentList.insertAdjacentHTML("afterbegin", message);
    elements.commentCount.innerHTML = numberOfComments;
    elements.commentMessage.value = "";
  }
}

document.addEventListener("DOMContentLoaded", () => {
  new App();
});
