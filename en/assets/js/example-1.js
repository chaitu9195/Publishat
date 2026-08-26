$(document).ready(function() {

	var eventLog = function(ctx, e) {
		var html = [
			"name: " + ctx.get("name"),
			"event.type: " + e.type
		];
		$(".events-plate").html(html.join("<br />"));
	};

	Math.rand = function(min, max) {
		return Math.floor(Math.random() * (max - min + 1)) + min;
	};

	$.prototype.mSelectDBox.prototype._globalStyles[".m-select-d-box__list-item_selected"]["background-color"] = "mediumseagreen";
	$.prototype.mSelectDBox.prototype._globalStyles[".m-select-d-box__list-item_selected:hover, .m-select-d-box__list-item_selected.m-select-d-box__list-item_hover"]["background-color"] = "green";
	$.prototype.mSelectDBox.prototype._globalStyles[".m-select-d-box__list-item:active, .m-select-d-box__list-item_selected:active"]["background-color"] = "darkgreen";

	$("#msdb-b").mSelectDBox({
		"list": [
			"alpha", "beta", "gamma", "delta",
			"epsilon", "zeta", "eta", "theta", "iota",
			"kappa", "lambda", "mu", "nu", "xi",
			"omicron", "pi", "rho", "sigma", "tau",
			"upsilon", "phi", "chi", "psi", "omega"
		],
		"builtInInput": 0,
		"multiple": true,
		"autoComplete": true,
		"onkeydown": eventLog,
		"input:empty": eventLog,
		"name": "b"
	});
});