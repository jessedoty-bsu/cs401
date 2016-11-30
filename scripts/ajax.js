window.onload = function() { setInterval(refreshList, 3000); };

function refreshList() {
   $("#list_title").load(location.href+" #list_title>*","");
   $("#list_container").load(location.href+" #list_container>*","");
}

function newList(id) {
   var content = prompt("Please enter the item's name.", "New List");
   content = content ? content:"New List";

   var value = { "new_list_title":content };
   $.ajax({
      type: "POST",
      url: "../handlers/list.php",
      data: value,
      success: function () {
         //Prepend button for new list to list_ul
         $("#list_ul").prepend(
             "<li><button id=\"" + content + "\">" + content + "</button></li>"
         );

         //Refresh list view
         refreshList();

         //Load share options since they have become enabled
         $("#share_options").load(location.href+" #share_options>*","");
      },
      error: function () {
         alert("New list failed.");
      }
   });
}

function newItem() {
   var content = prompt("Please enter the item's name.", "New Item");
   content = content ? content:"New Item";

   var listID = $("#list_id").val();
   var values = { "list_id":listID, "new_item_content":content };
   $.ajax({
      type: "POST",
      url: "../handlers/list.php",
      data: values,
      success: function () {
         //Refresh list view
         refreshList();
      },
      error: function () {
         alert("New item failed.");
      }
   });
}

$("#item_list").append()


