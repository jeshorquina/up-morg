(function (DomHelper, EventsFactory) {

  EventsFactory.CreateEventSection = function (event) {

    var image = "";
    if (new Boolean(event.image) != false) {
      image = DomHelper.CreateElement("div", {}, [
        DomHelper.CreateElement("img", {
          "src": event.image,
          "class": "width-full"
        }),
        DomHelper.CreateElement("hr", {})
      ]);
    }

    return DomHelper.CreateElement("div", { "class": "card margin-top-xlarge" },
      [
        DomHelper.CreateElement("div", {
          "class": "flex-container"
        }, [
            DomHelper.CreateElement("h2", {
              "class": "flex flex-1 no-margin"
            }, event.name),
            DomHelper.CreateElement("div", {
              "class": "flex flex-1 text-right"
            }, [
                DomHelper.CreateElement("strong", {}, "Event Date: "),
                DomHelper.CreateElement("div", {}, event.date)
              ]
            )
          ]
        ),
        DomHelper.CreateElement("hr", {}),
        image,
        DomHelper.CreateElement("p", {}, event.description),
        DomHelper.CreateElement("hr", {}),
        DomHelper.CreateElement("div", { "class": "flex-container" }, [
          DomHelper.CreateElement("div", {
            "class": "flex flex-1"
          }, [
              DomHelper.CreateElement("strong", {}, "Posted by: "),
              event.owner
            ]
          ),
          DomHelper.CreateElement("div", {
            "class": "flex flex-1 text-right"
          }, [
              DomHelper.CreateElement(
                "strong", {}, "Posted on: "
              ), event.timestamp
            ]
          )
        ]),
      ]
    )
  }

})(
  DomHelper, this.EventsFactory = (
    this.EventsFactory == undefined
  ) ? {} : this.EventsFactory
  );