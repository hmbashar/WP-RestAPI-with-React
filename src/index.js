import React from "react";
import ReactDOM from "react-dom";
import App from "./App";


document.addEventListener("DOMContentLoaded", function () {
  let element = document.getElementById("cb-wp-admin-dash-app");
  if (typeof element !== "undefined" && element !== null) {
    ReactDOM.render(<App />, document.getElementById("cb-wp-admin-dash-app"));
  }
});