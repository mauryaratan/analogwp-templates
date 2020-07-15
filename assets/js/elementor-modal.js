/* global elementor, elementorCommon */
/* eslint-disable */

const analog = window.analog = window.analog || {};
const analogBlocks = window.analogBlocks = window.analogBlocks || {};

"undefined" != typeof jQuery &&
	!(function($) {
		$(function() {
			function modal() {
				const insertIndex = 0 < jQuery(this).parents(".elementor-section-wrap").length ? jQuery(this).parents(".elementor-add-section").index() : -1;

				analog.insertIndex = insertIndex;

				elementorCommon &&
					(window.analogModal ||
						((window.analogModal = elementorCommon.dialogsManager.createWidget(
							"lightbox",
							{
								id: "analogwp-templates-modal",
								headerMessage: "What is this???",
								message: "",
								hide: {
									auto: !1,
									onClick: !1,
									onOutsideClick: !1,
									onOutsideContextMenu: !1,
									onBackgroundClick: !0
								},
								position: {
									my: "center",
									at: "center"
								},
								onShow: function() {
									const content = window.analogModal.getElements("content");
									content.append('<div id="analogwp-templates"></div>');
									var event = new Event("modal-close");
									$("#analogwp-templates").on(
										"click",
										".close-modal",
										function() {
											document.dispatchEvent(event);
											return window.analogModal.hide(), !1;
										}
									);
								},
								onHide: function() {}
							}
						)),
						window.analogModal.getElements("header").remove(),
						window.analogModal
							.getElements("message")
							.append(window.analogModal.addElement("content"))),
					window.analogModal.show());
			}

			function blocksModal() {
				const insertIndex = 0 < jQuery(this).parents(".elementor-section-wrap").length ? jQuery(this).parents(".elementor-add-section").index() : -1;

				analogBlocks.insertIndex = insertIndex;

				elementorCommon &&
					(window.analogBlocksModal ||
						((window.analogBlocksModal = elementorCommon.dialogsManager.createWidget(
							"lightbox",
							{
								id: "analogwp-blocks-modal",
								headerMessage: "What is this???",
								message: "",
								hide: {
									auto: !1,
									onClick: !1,
									onOutsideClick: !1,
									onOutsideContextMenu: !1,
									onBackgroundClick: !0
								},
								position: {
									my: "center",
									at: "center"
								},
								onShow: function() {
									const content = window.analogBlocksModal.getElements("content");
									content.append('<div id="analogwp-blocks"></div>');
									var event = new Event("modal-close");
									$("#analogwp-blocks").on(
										"click",
										".close-modal",
										function() {
											document.dispatchEvent(event);
											return window.analogBlocksModal.hide(), !1;
										}
									);
								},
								onHide: function() {}
							}
						)),
						window.analogBlocksModal.getElements("header").remove(),
						window.analogBlocksModal
							.getElements("message")
							.append(window.analogBlocksModal.addElement("content"))),
					window.analogBlocksModal.show());
			}

			window.analogModal = null;
			window.analogBlocksModal = null;

			const template = $("#tmpl-elementor-add-section");

			if (0 < template.length && typeof elementor !== undefined) {
				let text = template.text();

				(text = text.replace(
					'<div class="elementor-add-section-drag-title',
					'<div class="elementor-add-section-area-button elementor-add-analogwp-button" title="AnalogWP Templates">&nbsp;</div> <div class="elementor-add-section-drag-title'
				)),
					template.text(text),
					elementor.on("preview:loaded", function() {
						$(elementor.$previewContents[0].body).on(
							"click",
							".elementor-add-analogwp-button",
							modal
						);
					});

					(text = text.replace(
						'<div class="elementor-add-section-drag-title',
						'<div class="elementor-add-section-area-button elementor-add-analogwp-blocks-button" title="AnalogWP Blocks">&nbsp;</div> <div class="elementor-add-section-drag-title'
					)),
						template.text(text),
						elementor.on("preview:loaded", function() {
							$(elementor.$previewContents[0].body).on(
								"click",
								".elementor-add-analogwp-blocks-button",
								blocksModal
							);
						});
			}
		});
	})(jQuery);
