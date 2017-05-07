(function (DomHelper, TaskDetailsViewFactory) {

  TaskDetailsViewFactory.CreateParentTaskLink = function (parent) {

    var parentTitle = (parent.title.length > 20) ? (
      parent.title.substr(0, 20) + "...") : parent.title;

    return DomHelper.CreateElement("a", {
      "id": "parent-task-title-link",
      "class": "hover",
      "data-task-id": parent.id
    }, parentTitle);
  }

  TaskDetailsViewFactory.CreateDeadline = function (deadline) {

    var q = new Date();
    var currentDate = new Date(q.getFullYear(), q.getMonth(), q.getDate());
    var dateDeadline = new Date(deadline);

    var deadlineClass = (currentDate > dateDeadline) ? "label-text-red" : "";

    return DomHelper.CreateElement(
      "span", { "class": deadlineClass }, deadline
    )
  }

  TaskDetailsViewFactory.CreateEditButton = function (taskID) {

    return DomHelper.CreateElement(
      "button", {
        "class": "button button-info button-small margin-right-small",
        "id": "edit-task-button",
        "data-task-id": taskID
      }, DomHelper.CreateElement(
        "span", { "class": "icon-edit" }, " Edit"
      )
    );
  }

  TaskDetailsViewFactory.CreateDeleteButton = function (taskID) {

    return DomHelper.CreateElement(
      "button", {
        "class": "button button-danger-border button-small",
        "id": "delete-task-button",
        "data-task-id": taskID
      }, DomHelper.CreateElement(
        "span", { "class": "icon-delete" }, " Delete"
      )
    );
  }

  TaskDetailsViewFactory.CreateStatusLabel = function (status) {

    var labelClass = "";
    switch (status.toLowerCase()) {
      case "to do":
        labelClass = "label-gray";
        break;
      case "in progress":
        labelClass = "label-yellow";
        break;
      case "for review":
        labelClass = "label-blue";
        break;
      case "needs changes":
        labelClass = "label-red";
        break;
      case "accepted":
        labelClass = "label-green";
        break;
      case "done":
        labelClass = "label-purple";
        break;
      default:
        labelClass = "label-blue";
        break;
    }

    return DomHelper.CreateElement(
      "span", {
        "class": "label " + labelClass
      }, status
    )
  }

  TaskDetailsViewFactory.CreateSubtaskList = function (children) {

    var subtaskList = DomHelper.CreateElement(
      "ul", { "class": "list list-strips" }
    )

    DomHelper.InsertContent(
      subtaskList, TaskDetailsViewFactory.CreateListHeader("Subtasks")
    );
    children.forEach(function (child, index) {
      DomHelper.AppendContent(
        subtaskList, TaskDetailsViewFactory.CreateListRow(child, index)
      )
    });

    return subtaskList;
  }

  TaskDetailsViewFactory.CreateListHeader = function (label) {

    return DomHelper.CreateElement("li", { "class": "list-header" }, label);
  }

  TaskDetailsViewFactory.CreateListRow = function (child, index) {

    var labelClass = "";
    switch (child.status.toLowerCase()) {
      case "to do":
        labelClass = "label-gray";
        break;
      case "in progress":
        labelClass = "label-yellow";
        break;
      case "for review":
        labelClass = "label-blue";
        break;
      case "needs changes":
        labelClass = "label-red";
        break;
      case "accepted":
        labelClass = "label-green";
        break;
      case "done":
        labelClass = "label-purple";
        break;
      default:
        labelClass = "label-blue";
        break;
    }

    var q = new Date();
    var currentDate = new Date(q.getFullYear(), q.getMonth(), q.getDate());
    var deadline = new Date(child.deadline);

    var deadlineClass = (currentDate > deadline) ? "label-text-red" : "";

    return DomHelper.CreateElement("li", {
      "class": "hover flex-container view-task-details",
      "data-task-id": child.id
    }, [
        DomHelper.CreateElement("div", {
          "class": "flex flex-1"
        }, [
            DomHelper.CreateElement("div", {
              "class": "align-middle"
            }, [
                DomHelper.CreateElement("span", {
                  "class": "cell"
                }, (index + 1) + ". " + child.title)
              ])
          ]),
        DomHelper.CreateElement("div", {
          "class": "flex flex-1 text-right align-middle"
        }, [
            DomHelper.CreateElement("span", {
              "class": "label " + labelClass + " margin-right-small"
            }, child.status),
            DomHelper.CreateElement("span", {
              "class": "cell " + deadlineClass
            }, child.deadline)
          ])
      ]);
  }

  TaskDetailsViewFactory.CreateEmptyCommentRow = function () {

    return DomHelper.CreateElement(
      "li", {}, "There are no comments for this task."
    );
  }

  TaskDetailsViewFactory.CreateCommentRow = function (comment) {

    return DomHelper.CreateElement("li", {}, [
      DomHelper.CreateElement("div", {
        "class": "flex-container"
      }, [
          DomHelper.CreateElement(
            "div", { "class": "flex flex-1" }, [
              DomHelper.CreateElement("strong", {}, "Author: "),
              comment.commentor
            ]),
          DomHelper.CreateElement(
            "div", { "class": "flex flex-1 text-right" }, [
              DomHelper.CreateElement("strong", {}, "Published: "),
              comment.timestamp
            ]
          )
        ]),
      DomHelper.CreateElement("div", {
        "class": "width-full margin-top-small task-comment"
      }, comment.comment)
    ]);
  }

  TaskDetailsViewFactory.CreateToDoSubmitSection = function (statusID) {

    return DomHelper.CreateElement(
      "div", { "class": "text-center margin-top-medium" }, [
        DomHelper.CreateElement(
          "input", {
            "type": "hidden",
            "name": "task-status",
            "value": statusID
          }
        ),
        DomHelper.CreateElement(
          "button", {
            "class": "button button-success no-margin",
            "type": "submit"
          }, "Start on task"
        )
      ]
    );
  }

  TaskDetailsViewFactory.CreateInProgressSubmitSection = function (statusID) {

    return DomHelper.CreateElement(
      "div", { "class": "clearfix margin-top-medium" }, [
        DomHelper.CreateElement(
          "input", {
            "type": "hidden",
            "name": "task-status",
            "value": statusID
          }
        ),
        DomHelper.CreateElement(
          "div", { "class": "form-group" }, [
            DomHelper.CreateElement(
              "label", { "class": "form-label" }, "Submit task"
            ),
            DomHelper.CreateElement(
              "textarea", {
                "class": "form-input width-full",
                "name": "task-submission-text",
                "row": "3",
                "required": "required"
              }
            )
          ]
        ),
        DomHelper.CreateElement(
          "div", { "class": "form-group" }, [
            DomHelper.CreateElement(
              "input", {
                "type": "file",
                "class": "form-input width-full",
                "name": "task-submission-file"
              }
            )
          ]
        ),
        DomHelper.CreateElement(
          "button", {
            "class": "button button-success button-small no-margin margin-top-small float-right",
            "type": "submit"
          }, "Submit Task"
        )
      ]
    );
  }

  TaskDetailsViewFactory.CreateForReviewSubmitSection = function (
    submissions, statusID
  ) {

    var submissionList = DomHelper.CreateElement(
      "ul", { "class": "list list-strips margin-top-medium" }, [
        DomHelper.CreateElement("li", {
          "class": "list-header"
        }, "Submissions")
      ]
    );

    submissions.forEach(function (submission) {
      DomHelper.AppendContent(
        submissionList, DomHelper.CreateElement(
          "li", {}, [
            DomHelper.CreateElement(
              "div", { "class": 'width-full' }, [
                DomHelper.CreateElement(
                  "strong", {}, "Description: "
                ),
                submission.description
              ]
            ),
            DomHelper.CreateElement("hr", { "class": "margin-vertical-small" }),
            DomHelper.CreateElement(
              "div", { "class": 'flex-container' }, [
                DomHelper.CreateElement(
                  "div", { "class": 'flex flex-2' }, [
                    DomHelper.CreateElement(
                      "strong", {}, "File upload: "
                    ),
                    DomHelper.CreateElement(
                      "a", {
                        "href": submission.file.url,
                        "target": "_blank"
                      }, submission.file.name
                    )
                  ]
                ),
                DomHelper.CreateElement(
                  "div", {
                    "class": 'flex flex-1 text-right'
                  }, [
                    DomHelper.CreateElement(
                      "strong", {}, "Timestamp: "
                    ),
                    submission.timestamp
                  ]
                )
              ]
            ),
          ]
        )
      );
    });

    return DomHelper.CreateElement(
      "div", { "class": "clearfix margin-top-medium" }, [
        DomHelper.CreateElement("p", {},
          "Task is awaiting approval. There is nothing you can do by this " +
          "time. You can modify your submission if you are unsure of it."
        ),
        submissionList,
        DomHelper.CreateElement(
          "input", {
            "type": "hidden",
            "name": "task-status",
            "value": statusID
          }
        ),
        DomHelper.CreateElement("div", { "class": "clearfix margin-top-small" },
          DomHelper.CreateElement("button", {
            "class": "button button-success button-small float-right no-margin",
            "type": "submit"
          }, "Modify Submission")
        )
      ]
    );
  }

  TaskDetailsViewFactory.CreateForReviewApproveSection = function (
    submissions, statusID
  ) {

    var submissionList = DomHelper.CreateElement(
      "ul", { "class": "list list-strips" }, [
        DomHelper.CreateElement("li", {
          "class": "list-header"
        }, "Submissions")
      ]
    );

    submissions.forEach(function (submission) {
      DomHelper.AppendContent(
        submissionList, DomHelper.CreateElement(
          "li", {}, [
            DomHelper.CreateElement(
              "div", { "class": 'width-full' }, [
                DomHelper.CreateElement(
                  "strong", {}, "Description: "
                ),
                submission.description
              ]
            ),
            DomHelper.CreateElement("hr", { "class": "margin-vertical-small" }),
            DomHelper.CreateElement(
              "div", { "class": 'flex-container' }, [
                DomHelper.CreateElement(
                  "div", { "class": 'flex flex-2' }, [
                    DomHelper.CreateElement(
                      "strong", {}, "File upload: "
                    ),
                    DomHelper.CreateElement(
                      "a", {
                        "href": submission.file.url,
                        "target": "_blank"
                      }, submission.file.name
                    )
                  ]
                ),
                DomHelper.CreateElement(
                  "div", {
                    "class": 'flex flex-1 text-right'
                  }, [
                    DomHelper.CreateElement(
                      "strong", {}, "Timestamp: "
                    ),
                    submission.timestamp
                  ]
                )
              ]
            ),
          ]
        )
      );
    });

    return DomHelper.CreateElement(
      "div", { "class": "clearfix margin-top-medium" }, [
        submissionList,
        DomHelper.CreateElement(
          "input", {
            "type": "hidden",
            "name": "task-status",
            "value": statusID
          }
        ),
        DomHelper.CreateElement("div", { "class": "clearfix margin-top-small" },
          [
            DomHelper.CreateElement("button", {
              "class": "button button-danger button-small float-right no-margin margin-right-small",
              "type": "submit"
            }, "Disapprove"),
            DomHelper.CreateElement("button", {
              "class": "button button-success button-small float-right no-margin margin-right-small",
              "type": "submit"
            }, "Approve")
          ]
        )
      ]
    );
  }

})(
  DomHelper, this.TaskDetailsViewFactory = (
    this.TaskDetailsViewFactory == undefined
  ) ? {} : this.TaskDetailsViewFactory
  );