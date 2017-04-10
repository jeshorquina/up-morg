(function (BatchOperations) {

  var source = document
    .getElementsByTagName("body")[0]
    .getAttribute("data-source");

  BatchOperations.RenderBatches(source);

})(BatchOperations);
