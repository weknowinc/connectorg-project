// custom js here

jQuery(function () {
  // Enables the waffle menu in the header.
  jQuery('.waffle-tools').popover({
    html: true,
    content: `<div class="waffle-tools-container">${jQuery('.waffle-tools-container').html()}</div>`,
    template: '<div class="popover" role="tooltip"><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
  });
});
