
LoadAll();

function LoadAll() {
	InjectScript("http://code.jquery.com/jquery-1.9.1.js", function() {
		InjectScript("https://pizzabtn.herokuapp.com/javascripts/jquery.pep.min.js", function() {
			InjectScript("https://pizzabtn.herokuapp.com/javascripts/jquery.fancybox.js", function() {
				InjectScript("https://pizzabtn.herokuapp.com/javascripts/probtn.js", function() {
					$.noConflict();
					
					jQuery(document).StartButton({
				        "mainStyleCss": "https://pizzabtn.herokuapp.com/stylesheets/probtn.css",
				        "jqueryPepPath": "https://pizzabtn.herokuapp.com/javascripts/jquery.pep.min.js",
				        "fancyboxJsPath": "https://pizzabtn.herokuapp.com/javascripts/jquery.fancybox.js",
				        "fancyboxCssPath": "https://pizzabtn.herokuapp.com/stylesheets/jquery.fancybox.css",
				    });
				});
			});
		});
	});
}

function InjectScript(name, callback) {
	var s = document.createElement('script');
	s.src = name;
	s.onload = function() {
		try {
			callback();
		} catch(ex) {};
		//this.parentNode.removeChild(this);
	};
	(document.head||document.documentElement).appendChild(s);
}