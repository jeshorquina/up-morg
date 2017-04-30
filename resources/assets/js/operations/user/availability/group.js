(function (
  DomHelper, HttpHelper, UrlHelper, AlertFactory,
  AvailabilityGroupFactory, AvailabilityGroupOperations
) {

  AvailabilityGroupOperations.RenderAvailabilityGroupPage = function (
    source, controllerCallback
  ) {

    var endpoint = source + "action/availability/group";
    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderAvailabilityGroupCallback(status, responseText, controllerCallback);
    });
  }

  AvailabilityGroupOperations.AddGroup = function (source, controllerCallback) {

    var endpoint = source + "action/availability/group/add";
    var form = document.getElementById("add-group-form");

    var data = new FormData(form);

    HttpHelper.Post(endpoint, data, function (status, responseText) {
      AddGroupCallback(status, responseText, controllerCallback);
    });
  }

  AvailabilityGroupOperations.ViewGroup = function (source, groupID) {
    UrlHelper.Redirect(source + "availability/group/view/" + groupID);
  }

  AvailabilityGroupOperations.EditGroup = function (source, groupID) {
    UrlHelper.Redirect(source + "availability/group/edit/" + groupID);
  }

  AvailabilityGroupOperations.DeleteGroup = function (
    source, groupID, csrfObject, controllerCallback
  ) {

    var data = new FormData();
    data.append("group-id", groupID);
    data.append(csrfObject.name, csrfObject.value);

    var endpoint = source + "action/availability/group/delete";

    HttpHelper.Post(endpoint, data, function (status, responseText) {
      DeleteGroupCallback(status, responseText, controllerCallback);
    });
  }

  function AddGroupCallback(status, responseText, controllerCallback) {

    if (status == HttpHelper.CREATED) {
      DomHelper.InputValue("group-name", "");
    }
    GroupProcessCallback(status, responseText, controllerCallback);
  }

  function DeleteGroupCallback(status, responseText, controllerCallback) {
    GroupProcessCallback(status, responseText, controllerCallback);
  }

  function GroupProcessCallback(status, responseText, controllerCallback) {

    var response = JSON.parse(responseText);
    var container = document.getElementById("notifications");

    window.scrollTo(0, 0);

    if (status == HttpHelper.OK || status == HttpHelper.CREATED) {

      RenderAvailabilityGroupCallback(status, responseText, controllerCallback);
      AlertFactory.GenerateSuccessAlert(container, response.message);
    }
    else {
      AlertFactory.GenerateDangerAlert(container, response.message);
    }
  }

  function RenderAvailabilityGroupCallback(
    status, responseText, controllerCallback
  ) {

    var response = JSON.parse(responseText);

    if (status == HttpHelper.OK || status == HttpHelper.CREATED) {

      FillGroupList(response.data.groups);
      controllerCallback();
    }
    else {

      window.scrollTo(0, 0);
      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );
    }
  }

  function FillGroupList(groups) {

    var groupContainer = document.getElementById("group-list");

    if (groups.length > 0) {

      DomHelper.ClearContent(groupContainer);
      groups.forEach(function (group) {
        DomHelper.AppendContent(
          groupContainer, AvailabilityGroupFactory.CreateGroupRow(group)
        );
      });
    }
    else {

      DomHelper.InsertContent(
        groupContainer, AvailabilityGroupFactory.CreateEmptyGroupRow()
      );
    }

  }

})(
  DomHelper, HttpHelper, UrlHelper, AlertFactory, AvailabilityGroupFactory,
  this.AvailabilityGroupOperations = (
    this.AvailabilityGroupOperations == undefined
  ) ? {} : this.AvailabilityGroupOperations
  );