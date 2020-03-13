function onlyOne(checkbox) {
  var checkboxes = document.querySelectorAll(".ProgCheck");
  checkboxes.forEach(item => {
    // console.log(item);
    if (item !== checkbox) item.checked = false;
  });
}
