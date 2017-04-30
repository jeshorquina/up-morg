(function (
  DomHelper, HttpHelper, UrlHelper, AlertFactory,
  AvailabilityGroupEditFactory, AvailabilityGroupEditOperations
) {

  AvailabilityGroupEditOperations.RenderAvailabilityGroupEditPage = function (
    source, groupID, controllerCallback
  ) {

    var endpoint = source + "action/availability/group/edit/" + groupID;
    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderAvailabilityGroupEditCallback(
        status, responseText, controllerCallback
      );
    });
  }

  AvailabilityGroupEditOperations.AddGroupMember = function (
    source, groupID, form, controllerCallback
  ) {

    var data = new FormData(form);
    var endpoint = (
      source + "action/availability/group/edit/" + groupID + "/add"
    );

    HttpHelper.Post(endpoint, data, function (status, responseText) {
      RefreshRenderAvailabilityGroupEditCallback(
        status, responseText, controllerCallback
      );
    });
  }

  AvailabilityGroupEditOperations.RemoveGroupMember = function (
    source, groupID, memberID, csrfObject, controllerCallback
  ) {

    var data = new FormData();
    data.append("member-id", memberID);
    data.append(csrfObject.name, csrfObject.value);

    var endpoint = (
      source + "action/availability/group/edit/" + groupID + "/delete"
    );

    HttpHelper.Post(endpoint, data, function (status, responseText) {
      RefreshRenderAvailabilityGroupEditCallback(
        status, responseText, controllerCallback
      );
    });
  }

  function RenderAvailabilityGroupEditCallback(
    status, responseText, controllerCallback
  ) {

    var response = JSON.parse(responseText);

    if (status == HttpHelper.OK || status == HttpHelper.CREATED) {

      FillGroupName(response.data.group.name);
      FillSelectMember(response.data.members);
      FillGroupMemberList(response.data.group.members);

      controllerCallback();
    }
    else {

      window.scrollTo(0, 0);
      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );
    }
  }

  function RefreshRenderAvailabilityGroupEditCallback(
    status, responseText, controllerCallback
  ) {

    var response = JSON.parse(responseText);

    window.scrollTo(0, 0);

    if (status == HttpHelper.OK || status == HttpHelper.CREATED) {

      FillGroupName(response.data.group.name);
      FillSelectMember(response.data.members);
      FillGroupMemberList(response.data.group.members);

      controllerCallback();

      AlertFactory.GenerateSuccessAlert(
        document.getElementById("notifications"), response.message
      );
    }
    else {

      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );
    }
  }

  function FillGroupName(groupName) {

    var groupNameContainers = document.getElementsByClassName("group-name");
    for (var i = 0; i < groupNameContainers.length; i++) {
      DomHelper.InsertContent(groupNameContainers[i], groupName);
    }
  }

  function FillSelectMember(nonMembers) {

    var list = document.getElementById("add-group-member-list");
    DomHelper.InsertContent(
      list, AvailabilityGroupEditFactory.CreateDefaultOption()
    );

    nonMembers.forEach(function (member) {
      DomHelper.AppendContent(
        list, AvailabilityGroupEditFactory.CreateOption(member)
      )
    })
  }

  function FillGroupMemberList(members) {

    var groupListContainer = document.getElementById("group-member-list");
    if (members.length === 0) {
      DomHelper.InsertContent(
        groupListContainer,
        AvailabilityGroupEditFactory.CreateEmptyMemberItem()
      )
    }
    else {
      DomHelper.ClearContent(groupListContainer);
      members.forEach(function (member) {
        DomHelper.AppendContent(
          groupListContainer,
          AvailabilityGroupEditFactory.CreateMemberItem(member)
        );
      });
    }
  }

})(
  DomHelper, HttpHelper, UrlHelper, AlertFactory, AvailabilityGroupEditFactory,
  this.AvailabilityGroupEditOperations = (
    this.AvailabilityGroupEditOperations == undefined
  ) ? {} : this.AvailabilityGroupEditOperations
  );