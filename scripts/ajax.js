window.onload = function() { setInterval(refreshList, 3000); };

/* Refresh list title and item list view */
function refreshList() {
   refreshListTitle();
   refreshListTabs();
   refreshItems();
}

/* Refresh list title */
function refreshListTitle() {
   $("#list_title").load(location.href+" #list_title>*","");
}

/* Refresh item list view */
function refreshItems() {
   $("#list_container").load(location.href+" #list_container>*","");
}

/* Refresh list tabs */
function refreshListTabs() {
   $("#list_tabs").load(location.href+" #list_tabs>*","");
}

/* Add a new list*/
function newList() {
   var content = prompt("Please enter the item's name.", "New List");
   //Hitting cancel on the prompt returns null
   if (content != null) {
      //Check if user gave an empty string
      content = content ? content : "New Item";
      console.log("Adding new list: " + content);

      var value = {"new_list_title": content};
      $.ajax({
         type: "POST",
         url: "../handlers/list.php",
         data: value,
         success: function () {
            //Prepend button for new list to list_ul
            // $("#list_ul").prepend(
            //     "<li><button id=\"" + content + "\">" + content + "</button></li>"
            // );

            //Refresh list view
            refreshList();

            //Reload share options since they have become enabled
            $("#share_options").load(location.href + " #share_options>*", "");
         },
         error: function () {
            alert("New list failed.");
         }
      });
   }
}

/* Add a new item to a list*/
function newItem(id) {
   var content = prompt("Please enter the item's name.", "New Item");
   //Hitting cancel on the prompt returns null
   if (content != null) {
      //Check if user gave an empty string
      content = content ? content : "New Item";
      console.log("Adding new item.");

      var values = {"list_id": id, "new_item_content": content};
      $.ajax({
         type: "POST",
         url: "../handlers/list.php",
         data: values,
         success: function () {
            //Refresh list view
            refreshItems();
         },
         error: function () {
            alert("New item failed.");
         }
      });
   }
}

/* Toggle checked status of an item */
function toggleChecked(id, checked) {
   console.log(id + " " + checked);
   var values = { "item_id":id, "checked":checked };
   $.ajax({
      type: "POST",
      url: "../handlers/list.php",
      data: values,
      success: function () {
         refreshItems();
      },
      error: function () {
         alert("Item check toggle failed.");
      }
   });
}

/* Switch the view to a different list */
function switchToList(id) {
   var values = { "list_id":id };
   $.ajax({
      type: "POST",
      url: "../handlers/list.php",
      data: values,
      success: function () {
         refreshList();
      },
      error: function () {
         alert("List view switch failed.");
      }
   });
}

/* Share the given list with a user */
function share(listID) {
   var user = prompt("Enter the email address of the user you would like to share this list with.");
   //Hitting cancel on the prompt returns null
   if (user != null) {
       //If no email was given alert the user of invalid data and exit the call
       if (!user) {
           alert("Error: No email address was entered.");
           return false;
       }

       var values = {"user": user, "share_list_id": listID};
       $.ajax({
           type: "POST",
           url: "../handlers/list.php",
           data: values,
           success: function () {
           },
           error: function () {
               alert("List view switch failed.");
           }
       });
   }
}
