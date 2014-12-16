// Browser data - from
// http://stackoverflow.com/questions/9514179/how-to-find-the-operating-system-version-using-javascript
(function (window) {
    try {
        var unknown = 'Unbekannt';

        // screen
        var screenSize = '';
        var width = '';
        var height = '';
        if (screen.width) {
            width = (screen.width) ? screen.width : '';
            height = (screen.height) ? screen.height : '';
            screenSize += '' + width + " x " + height;
        }

        //browser
        var nVer = navigator.appVersion;
        var nAgt = navigator.userAgent;
        var browser = navigator.appName;
        var version = '' + parseFloat(navigator.appVersion);
        var majorVersion = parseInt(navigator.appVersion, 10);
        var nameOffset, verOffset, ix;

        // Opera
        if ((verOffset = nAgt.indexOf('Opera')) != -1) {
            browser = 'Opera';
            version = nAgt.substring(verOffset + 6);
            if ((verOffset = nAgt.indexOf('Version')) != -1) {
                version = nAgt.substring(verOffset + 8);
            }
        }
        // MSIE
        else if ((verOffset = nAgt.indexOf('MSIE')) != -1) {
            browser = 'Microsoft Internet Explorer';
            version = nAgt.substring(verOffset + 5);
        }
        // Chrome
        else if ((verOffset = nAgt.indexOf('Chrome')) != -1) {
            browser = 'Chrome';
            version = nAgt.substring(verOffset + 7);
        }
        // Safari
        else if ((verOffset = nAgt.indexOf('Safari')) != -1) {
            browser = 'Safari';
            version = nAgt.substring(verOffset + 7);
            if ((verOffset = nAgt.indexOf('Version')) != -1) {
                version = nAgt.substring(verOffset + 8);
            }
        }
        // Firefox
        else if ((verOffset = nAgt.indexOf('Firefox')) != -1) {
            browser = 'Firefox';
            version = nAgt.substring(verOffset + 8);
        }
        // Other browsers
        else if ((nameOffset = nAgt.lastIndexOf(' ') + 1) < (verOffset = nAgt.lastIndexOf('/'))) {
            browser = nAgt.substring(nameOffset, verOffset);
            version = nAgt.substring(verOffset + 1);
            if (browser.toLowerCase() == browser.toUpperCase()) {
                browser = navigator.appName;
            }
        }
        // trim the version string
        if ((ix = version.indexOf(';')) != -1) version = version.substring(0, ix);
        if ((ix = version.indexOf(' ')) != -1) version = version.substring(0, ix);

        majorVersion = parseInt('' + version, 10);
        if (isNaN(majorVersion)) {
            version = '' + parseFloat(navigator.appVersion);
            majorVersion = parseInt(navigator.appVersion, 10);
        }
        ////console.log("majorVersion"+majorVersion);

        // mobile version
        var mobile = /Mobile|mini|Fennec|Android|iP(ad|od|hone)/.test(nVer);

        // cookie
        var cookieEnabled = (navigator.cookieEnabled) ? true : false;

        if (typeof navigator.cookieEnabled == 'undefined' && !cookieEnabled) {
            document.cookie = 'testcookie';
            cookieEnabled = (document.cookie.indexOf('testcookie') != -1) ? true : false;
        }

        // system
        var os = unknown;
        var clientStrings = [
            {s:'Windows 3.11', r:/Win16/},
            {s:'Windows 95', r:/(Windows 95|Win95|Windows_95)/},
            {s:'Windows ME', r:/(Win 9x 4.90|Windows ME)/},
            {s:'Windows 98', r:/(Windows 98|Win98)/},
            {s:'Windows CE', r:/Windows CE/},
            {s:'Windows 2000', r:/(Windows NT 5.0|Windows 2000)/},
            {s:'Windows XP', r:/(Windows NT 5.1|Windows XP)/},
            {s:'Windows Server 2003', r:/Windows NT 5.2/},
            {s:'Windows Vista', r:/Windows NT 6.0/},
            {s:'Windows 7', r:/(Windows 7|Windows NT 6.1)/},
            {s:'Windows 8.1', r:/(Windows 8.1|Windows NT 6.3)/},
            {s:'Windows 8', r:/(Windows 8|Windows NT 6.2)/},
            {s:'Windows NT 4.0', r:/(Windows NT 4.0|WinNT4.0|WinNT|Windows NT)/},
            {s:'Windows ME', r:/Windows ME/},
            {s:'Android', r:/Android/},
            {s:'Open BSD', r:/OpenBSD/},
            {s:'Sun OS', r:/SunOS/},
            {s:'Linux', r:/(Linux|X11)/},
            {s:'iOS', r:/(iPhone|iPad|iPod)/},
            {s:'Mac OS X', r:/Mac OS X/},
            {s:'Mac OS', r:/(MacPPC|MacIntel|Mac_PowerPC|Macintosh)/},
            {s:'QNX', r:/QNX/},
            {s:'UNIX', r:/UNIX/},
            {s:'BeOS', r:/BeOS/},
            {s:'OS/2', r:/OS\/2/},
            {s:'Search Bot', r:/(nuhk|Googlebot|Yammybot|Openbot|Slurp|MSNBot|Ask Jeeves\/Teoma|ia_archiver)/}
        ];

        try {
            for (var id in clientStrings) {
                var cs = clientStrings[id];
                if (cs.r.test(nAgt)) {
                    os = cs.s;
                    break;
                }
            }

            var osVersion = unknown;

            if (/Windows/.test(os)) {
                osVersion = /Windows (.*)/.exec(os)[1];
                os = 'Windows';
            }
            switch (os) {
                case 'Mac OS X':
                    osVersion = /Mac OS X (10[\.\_\d]+)/.exec(nAgt)[1];
                    break;

                case 'Android':
                    osVersion = /Android ([\.\_\d]+)/.exec(nAgt)[1];
                    break;

                case 'iOS':
                    osVersion = /OS (\d+)_(\d+)_?(\d+)?/.exec(nVer);
                    osVersion = osVersion[1] + '.' + osVersion[2] + '.' + (osVersion[3] | 0);
                    break;

            }
        } catch(ex) {
            os = unknown;
        }

        var isiPad = navigator.userAgent.match(/iPad/i) != null;

        window.jscd = {
            screen: screenSize,
            screenWidth: width,
            screenHeight: height,
            browser: browser,
            browserVersion: version,
            browserMajorVersion: majorVersion,
            mobile: mobile,
            os: os,
            osVersion: osVersion,
            cookies: cookieEnabled,
            isiPad: isiPad
        };
    } catch(ex) {};
}(this));

(function ($) {

    function GetDeviceUID() {
                var probtnId = "1234";
                if(readCookie("probtnId") != null) {
                } else {
                    //set cookie
                    var currentdate = new Date();
                    currentdate = currentdate.getTime();
                    probtnId = currentdate.toString()+"-"+navigator.userAgent.toString().hashCode();
                    createCookie("probtnId", probtnId, 365);
                };
                probtnId = readCookie("probtnId");
                return probtnId;
    }

        var XProBtnToken = "b04bb84b22cdacb0d57fd8f8fd3bfeb8ad430d1b";

        String.prototype.hashCode = function(){
            var hash = 0, i, char;
            if (this.length == 0) return hash;
            for (i = 0, l = this.length; i < l; i++) {
                char  = this.charCodeAt(i);
                hash  = ((hash<<5)-hash)+char;
                hash |= 0; // Convert to 32bit integer
            }
            return hash;
        };

        function createCookie(name, value, days) {
            var expires = "";
            if(days) {
                var date = new Date();
                date.setTime(date.getTime()+(days*24*60*60*1000));
                expires = "; expires="+date.toGMTString();
            }
            document.cookie = name+"="+value+expires+"; path=/";
        }

        function readCookie(name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for(var i=0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') c = c.substring(1,c.length);
                if(c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
            }
            return null;
        }

        function eraseCookie(name) {
            createCookie(name, "", -1);
        }

    //load nessesary libraries and show button
    $.fn.StartButton = function (options) {
        if ((window.jscd.browserMajorVersion>"8") || (window.jscd.browser!=="Microsoft Internet Explorer")) {

        //plugin version
        var mainVersion = "1.1";

        var serverUrl = "//admin.probtn.com";

        var params = $.extend({
            TrackingLink: null,
            MinimizeWrapperTime: 600,
			OpenExternal: false,
            CampaignID: null,
			NeverClose: true,
			MaxHeight: 0,
			MaxWidth: 0,
            type: "iframe",
            domain: "",
            fancyboxJsPath: "//cdn.jsdelivr.net/fancybox/2.1.5/jquery.fancybox.min.js",
            fancyboxCssPath: "//cdn.jsdelivr.net/fancybox/2.1.5/jquery.fancybox.min.css",
            mainStyleCss: serverUrl+"/stylesheets/probtn.css",
            jqueryPepPath: "//cdn.jsdelivr.net/jquery.pep/0.6.3/jquery.pep.min.js",
            buttonAnimationTimeAfterFancybox: 40,

            HideAfterFirstShow: false,

			LoadFancyboxCSS: true,

            //base params
            ContentURL: "http://app.ecwid.com/jsp/2557212/m", //site url address
            BaseInsets: { // Базовое смещение от краев экрана с учетом статус бара
                T: 4.0,
                B: 4.0,
                L: 4.0,
                R: 4.0
            },
            ButtonEnabled: false, // Включена / выключена
            ButtonVisible: false, // видна / не видна
            // Кнопка
            ButtonOpenInsets: { // Смещение в открытом состоянии
                T: 32.0,
                B: 32.0,
                L: 32.0,
                R: 32.0
            },
            ButtonPosition: { // Позиция
                X: 0.5, // По умолчанию центр экрана
                Y: 0.5, // По умолчанию центр экрана
            },
            ButtonSize: { // Размер
                W: 64.0,
                H: 64.0,
            },
            ButtonDragSize: { // Размер при перемещении
                W: 68.0,
                H: 68.0
            },
            ButtonOpenSize: { // Размер в открытом состоянии
                W: 64.0,
                H: 64.0
            },
            ButtonInactiveSize: { // Размер в неактивном состоянии
                W: 64.0,
                H: 64.0
            },
            ButtonOpacity: 0.8, // Прозрачность
            ButtonDragOpacity: 1.0, // Прозрачность при перемещении
            ButtonOpenOpacity: 1.0, // Прозрачность в открытом состоянии
            ButtonInactiveOpacity: 0.5, // Прозрачность в неактивном состоянии
            ButtonImage: "//cdnjs.cloudflare.com/ajax/libs/probtn/1.0.0/images/probtn/gray.png",
            ButtonDragImage: "//cdnjs.cloudflare.com/ajax/libs/probtn/1.0.0/images/probtn/drag_gray.png",
            ButtonOpenImage: "//cdnjs.cloudflare.com/ajax/libs/probtn/1.0.0/images/probtn/drag_gray.png",
            ButtonInactiveImage: "//cdnjs.cloudflare.com/ajax/libs/probtn/1.0.0/images/probtn/drag_gray.png",

            ClosePosition: { // Позиция
                X: 0.5, // По умолчанию центр экрана
                Y: 0.5 // По умолчанию центр экрана
            },
            CloseSize: { // Размер
                W: 64,
                H: 64,
            },
            CloseActiveSize: { // Размер в активном состоянии
                W: 72,
                H: 72,
            },
            CloseOpacity: 0.6, // Прозрачность
            CloseActiveOpacity: 1.0, // Прозрачность в активном состоянии
            CloseImage: "//cdnjs.cloudflare.com/ajax/libs/probtn/1.0.0/images/probtn/close.png", // Ссылка на изображение
            CloseActiveImage: "//cdnjs.cloudflare.com/ajax/libs/probtn/1.0.0/images/probtn/close.png", // Ссылка на изображение в активном состоянии

            HintInsets: { // Смещение от краев
                T: 4.0,
                B: 4.0,
                L: 4.0,
                R: 4.0,
            },
            HintLabelInsets: { // Смещение для текста
                T: 4.0,
                B: 4.0,
                L: 4.0,
                R: 4.0
            },
            HintImageInsets: { // Бордюры для изображения
                T: 8.0,
                B: 8.0,
                L: 8.0,
                R: 8.0
            },
            HintText: "Press me", // Текст
            HintFont: { // Шрифт
                Family: "Arial",
                Size: 18
            },
            HintFontColor: { // Цвет
                R: 1.0,
                G: 1.0,
                B: 1.0,
                A: 1.0
            },
            VendorText: "",
            VendorSite: "#",
            VendorTextFont: {"Family":"Arial","Size":10},
            VendorTextColor: {"R":1,"G":1,"B":1,"A":1},
            VendorOpacity: 0.4,
            VendorColor: {"R":0,"G":0,"B":0,"A":1},

            HintOpacity: 0.8, // Прозрачность подсказки
            HintImage: "//cdnjs.cloudflare.com/ajax/libs/probtn/1.0.0/images/probtn/hint.png", // Ссылка на изображение

            HintArrowSize: { // Размер стрелки
                W: 8.0,
                H: 8.0,
            },
            HintArrowOffset: { // Нахлест стрелки
                T: 0.0,
                B: 0.0,
                L: 0.0,
                R: 0.0,
            },
            HintArrowImageT: "", // Ссылка на изображение
            HintArrowImageB: "", // Ссылка на изображение
            HintArrowImageL: "", // Ссылка на изображение
            HintArrowImageR: "", // Ссылка на изображение

			ContentSize: {
				X: "90%",
				Y: "90%"
			},
			IsManualSize: false,

            // Контент
            ContentInsets: { // Смещение от краев
                T: -2.0,
                B: -2.0,
                L: -2.0,
                R: -2.0,
            },
            ContentWebViewInsets: { // Смещение для WebView
                T: 12.0,
                B: 12.0,
                L: 12.0,
                R: 12.0,
            },
            ContentImageInsets: { // Бордюры для изображения
                T: 32.0,
                B: 32.0,
                L: 32.0,
                R: 32.0,
            },
            ContentOpacity: 1.0, // Прозрачность
            ContentBackOpacity: 1.0, // Прозрачность фоновой части контента
            ContentBackColor: { // Цвет фоновой части контента
                R: 0.0,
                G: 0.0,
                B: 0.0,
                A: 1.0,
            },
            ContentActivityColor: { // Цвет индикатора загрузки
                R: 0.0,
                G: 0.0,
                B: 0.0,
                A: 1.0,
            },
            ContentImage: "", // Ссылка на изображение

            ContentArrowSize: { // Размер стрелки
                W: 14.0,
                H: 14.0,
            },
            ContentArrowOffset: { // Нахлест стрелки
                T: 8.0,
                B: 8.0,
                L: 9.0,
                R: 9.0,
            },
            ContentArrowImageT: "", // Ссылка на изображение
            ContentArrowImageB: "", // Ссылка на изображение
            ContentArrowImageL: "", // Ссылка на изображение
            ContentArrowImageR: "", // Ссылка на изображение

            // Настройки анимации

            DefaultDuration: 0.1, // Стандартная длительность анимации
            DefaultDelay: 0.0, // Стандартная задежка анимации

            OpenDuration: 0.2, // Длительность анимации "Открытия"
            OpenDelay: 0.5, // Задержка анимации "Открытия"
            CloseDuration: 0.2, // Длительность анимации "Закрытия"
            CloseDelay: 0.5, // Задержка анимации "Закрытия"

            ButtonShowDuration: 0.2, // Длительность анимации "Показать"
            ButtonShowDelay: 0.0, // Задержка анимации "Показать"
            ButtonHideDuration: 0.2, // Длительность анимации "Скрыть"
            ButtonHideDelay: 0.0, // Задержка анимации "Скрыть"
            ButtonDragDuration: 0.1, // Длительность анимации "Начать перемещать"
            ButtonDragDelay: 0.0, // Задержка анимации "Начать перемещать"
            ButtonUndragDuration: 0.2, // Длительность анимации "Перестать перемещать"
            ButtonUndragDelay: 0.0, // Задержка анимации "Перестать перемещать"
            ButtonInactiveDuration: 0.1, // Длительность анимации "Переход в неактивное состояние"
            ButtonInactiveDelay: 5.0, // Время простоя перед переходом в неактивное состояние
            ButtonInertiaSpeed: 512.0, // Скорость анимации "Инерция"
            ButtonInertiaSpeedMin: 32.0, // Максимальная скорость анимации "Инерция"
            ButtonInertiaSpeedMax: 1024.0, // Минимальная скорость анимации "Инерция"
            ButtonInertiaFactor: 6.0, // Множитель анимации "Инерция"

            CloseShowDuration: 0.1, // Длительность анимации "Показать область закрытия"
            CloseShowDelay: 0.0, // Задержка анимации "Показать область закрытия"
            CloseHideDuration: 0.2, // Длительность анимации "Скрыть область закрытия"
            CloseHideDelay: 0.0, // Задержка анимации "Скрыть область закрытия"
            CloseActiveDuration: 0.1, // Длительность анимации "Активировать область закрытия"
            CloseActiveDelay: 0.0, // Задержка анимации "Активировать область закрытия"
            CloseUnactiveDuration: 0.1, // Длительность анимации "Деактивировать область закрытия"
            CloseUnactiveDelay: 0.0, // Задержка анимации "Деактивировать область закрытия"

            HintLaunchDuration: 30000.0, // Длительность анимации "Показать при запуске подсказку"
            HintLaunchDelay: 0.0, // Задержка анимации "Показать при запуске подсказку"
            HintShowDuration: 0.1, // Длительность анимации "Показать подсказку"
            HintShowDelay: 0.0, // Задержка анимации "Показать подсказку"
            HintHideDuration: 0.2, // Длительность анимации "Скрыть подсказку"
            HintHideDelay: 0.0, // Задержка анимации "Скрыть подсказку"

            ContentShowDuration: 0.1, // Длительность анимации "Показать контент"
            ContentShowDelay: 0.0, // Задержка анимации "Показать контент"
            ContentHideDuration: 0.2, // Длительность анимации "Скрыть контент"
            ContentHideDelay: 0.0, // Задержка анимации "Скрыть контент",

            HideInFrame: true, // Скрывать, если кнопка показывается внутри другой кнопки

            ZCustomCss: ""
        }, options);


        // hint style
        var hintTextStyle = {
            "opacity": params.HintOpacity,
            "font-size": params.HintFont.Size,
            "font-family": params.HintFont.Family,
            "color": "white",
            "padding": "4px",
            "background": "url('"+params.HintImage+"')",
        };

		if ((params.HintText=="") || (params.HintText==null)) {
			//alert("none");
			hintTextStyle.display = "none";
			hintTextStyle.opacity = "0.0";
		}

        var closeButton = initCloseButton();

        function changeBodySize() {
            var opts = {
                width: window.availWidth,
                height: window.availHeight
            }
            if(window.jscd.browser === "Microsoft Internet Explorer") {
                opts.overflow = "auto"
            }
            $('body').css(opts);

        }

        // landscape
        function isLandscape() {
            return ($(window).width() > $(window).height());
        }

        $(document).ready(function () {
            var currentDomain = document.domain.replace("www.","");
            if(currentDomain == "" || currentDomain == null) {
                currentDomain = "example.com";
            };

            var realDomain = currentDomain;
            //rewrite domain if it specified in plugins params
            if ((params.domain!="") && (params.domain!=null)) {
                currentDomain = params.domain;
            } else {
            };

            // orientation
            var supportsOrientationChange = "onorientationchange" in window;
            var orientationEvent = supportsOrientationChange ? "orientationchange" : "resize";

            var windowHeight = window.innerHeight;
            var windowWidth = window.innerWidth;


            var closeAfterOrientationChange = false;

            //when window is resized or changed orientation on device
            function onOrientationChange(e) {
                //console.log("orientationChange");
                MaximizeWrapper(function() {
                    pizzabtn.css('left', '20px');
                    pizzabtn.css('top', '20px');
                    MinimizeWrapper(function(){
                    }, 10);                    
                });

                if($.fancybox.isOpen) {
                    closeAfterOrientationChange = true;
                    $.fancybox.close();
                };
            }

            $(window).bind(orientationEvent, onOrientationChange);

			var operator = null;
			var settingsUrl = "";

			$.get("http://ip-api.com/json", function(response) {
				//если МТС, то "MobileOperator": "MTS RUS"
				//если Билайн, то "MobileOperator": "Beeline"
				var org = response.as.toLowerCase();
				if (org.indexOf("mts") > -1) {
					operator = "MTS RUS";
				}
				if (org.indexOf("beeline") > -1) {
					operator = "Beeline";
				}
				if (org.indexOf("vimpel") > -1) {
					operator = "Beeline";
				}

				//operator = "MTS RUS";

			if (operator===null) {
				settingsUrl = serverUrl+"/1/functions/getClientSettings?BundleID="+currentDomain+"&DeviceType=web&DeviceUID="+GetDeviceUID()+"&Location[Longitude]=0&Location[Latitude]=0&Version="+mainVersion+"&X-ProBtn-Token="+XProBtnToken+"&random="+Math.random()+"&callback=?";
			} else {
				settingsUrl = serverUrl+"/1/functions/getClientSettings?BundleID="+currentDomain+"&DeviceType=web&DeviceUID="+GetDeviceUID()+"&Location[Longitude]=0&Location[Latitude]=0&Version="+mainVersion+"&X-ProBtn-Token="+XProBtnToken+"&random="+Math.random()+"&MobileOperator="+operator+"&callback=?";
			}
            $.getJSON(settingsUrl,
                function(data) {
                    try {

                        try {                            
                            //var HintText = utf8_encode(data.result.HintText);
                            data.result.HintText = HintText;                            
                        } catch(ex) {
                            //////console.log(ex.toString());
                        }
                        $.extend(params, data.result, options);

						if (params.LoadFancyboxCSS===true) {
							$('head').append('<link rel="stylesheet" href="'+params.fancyboxCssPath+'" type="text/css" />');
						}

                        //add custom css to head
                        if ((params.ZCustomCss!=="") && (params.ZCustomCss!==null) && (params.ZCustomCss!==undefined)) {
                            $('head').append('<style type="text/css">'+params.ZCustomCss+'</style>');
                        }

                        hintTextStyle = {
                            "opacity": params.HintOpacity,
                            "font-size": params.HintFont.Size,
                            "font-family": params.HintFont.Family,
                            "color": "rgb("+ params.HintFontColor.R*100 +"%, "+params.HintFontColor.G*100+"%, "+params.HintFontColor.B*100+"%)",
                            "padding-left": params.HintLabelInsets.L,
                            "padding-top": params.HintLabelInsets.T,
                            "padding-right": params.HintLabelInsets.R,
                            "padding-bottom": params.HintLabelInsets.B,
                            "background": "url('"+params.HintImage+"')"
                        };
						if ((params.HintText=="") || (params.HintText==null)) {
							hintTextStyle.display = "none";
							hintTextStyle.opacity = "0.0";
						}
                    } catch(ex) {
                    };
                }).done(function(){}).fail(function(ex){
					////console.log("Fail:");
					console.dir(ex);
				}).always(CheckInFrame);
			}, "jsonp");


            function CheckInFrame() {
                if (params.HideInFrame === true && window.self !== window.top)
                { 
                    //do nothing                
                }
                else
                {
                    BeginButtonProcess();
                }
            };

            // XXX BEGIN BUTTON PROCESS
            function BeginButtonProcess() {
                //add button styles
                $('head').append('<link rel="stylesheet" href="'+params.mainStyleCss+'" type="text/css" />');

                //add classes for ios devices
                if (window.jscd.os==="iOS") {
                    $("body").addClass("btn_os_ios");
                    if (window.jscd.isiPad === true) {
                        $("body").addClass("btn_device_ipad");
                    } else {
                        $("body").addClass("btn_device_iphone");
                    }
                }

				if ((window.jscd.mobile)) {	
					$('head').append("<style type='text/css'> .fancybox-inner { -webkit-overflow-scrolling: touch !important; overflow: scroll !important;   } </style>");
                    /*.fancybox-iframe { min-width:  100% !important; width: 10px !important; position: absolute; overflow: visible; }*/
				} else {
					$('head').append("<style type='text/css'> .fancybox-inner { -webkit-overflow-scrolling: touch !important; overflow: hide !important; } </style>");
				};

				//var closeButton = initCloseButton();
				$('#closeButton').attr('src', params.CloseImage);

                // append pizzabtn and close btn styles
				if (params.NeverClose==false) {
					$('head').append(
						$('<style/>', {
							id: 'probtn_style',
							type: "text/css",
							html: [
								'#pizzabtn.pizzabtn_normal { display: block; clear: both; position: device-fixed !important; }',
								'.close_pro_button_normal{ width:'+params.CloseSize.W+'px; height:'+params.CloseSize.H+'px; opacity:'+params.CloseOpacity+'; display: block; clear: both; }',
							].join("\n")
						})
					);
				};

                // get or create pizzabtn
                var pizzabtn = initPizzaButton();

                // load fancybox and jquery.pep
                if(typeof $.fancybox == 'function') {
                     loadPep();
                } else {
                    $.getScript(params.fancyboxJsPath, loadPep); //fancybox end
                }

                function loadPep() {
                    try {
                        if(typeof $.pep.toggleAll == 'function') {
                             AllLoadedButtonProcess();
                        } else {
                            $.getScript(params.jqueryPepPath, AllLoadedButtonProcess);
                        };
                    } catch(ex) {
                        $.getScript(params.jqueryPepPath, AllLoadedButtonProcess);
                    };
                }

                ///
                function AllLoadedButtonProcess() {
                    SendStatisticsData();					
                    
                    SendBrowserStatsInfo();

                    /*//console.log($.fancybox.resize);
                    $.fancybox.resize = function() {
                        var overlay = jQuery(".fancybox-overlay").first();
                        if (overlay.is(':visible')) {
                            overlay.css('height', $(document).height());
                        }

                        var w = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
                        var h = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
                        //console.log("w - "+w);
                        //console.log("h - "+h);
                        var updated_width = w;
                        //if (updated_width > selectedOpts.width) { updated_width = selectedOpts.width; }

                        $("#fancybox-wrap, #fancybox-content").css("width", updated_width);  
                        
                        var updated_height = h;
                        //if (updated_height > selectedOpts.height) { updated_height = selectedOpts.height; }

                        $("#fancybox-wrap, #fancybox-content").css("width", updated_height);      

                        //$.fancybox.center(true);
                    };*/

                    // show button
                    if(params.ButtonEnabled && params.ButtonVisible) {
                        pizzabtn.show();
                    }
					
					if (params.ButtonVisible) {
						SendStatisticsData("Showed", 1);
					} else {
						//SendStatisticsData("Showed", 1);
					}

                    //hide hint after params.HintLaunchDuration time (in seconds)
                    pizzabtn.hideHintDelay();

                    //show hint with nessesary animation
                    pizzabtn.showHint();


                    // help vars
                    var overlaped = false;

                    pizzabtn.moved = false;
                    pizzabtn.pep({
                        // hardwareAccelerate: false,
                        useCSSTranslation: false,
                        constrainTo: 'parent',
                        // cssEaseString: 'cubic-bezier(0.225, 0.500, 0.580, 1.000)', //default
                        // cssEaseString: 'cubic-bezier(0, 1, 1, 1)', // fast
                        // cssEaseString: 'cubic-bezier(0, 0, 1, 1)', // linear
                        // cssEaseString: 'cubic-bezier(.42, 0, .58, 1)', // ease-in-out
                        // cssEaseString: 'cubic-bezier(0, 0, .58, 1)', // ease-out
                        cssEaseString: 'cubic-bezier(0, .50, .50, 1)',
                        cssEaseDuration: 300,
                        velocityMultiplier: 1.0,
                        startThreshold: [1, 1],
                        droppable: '#closeButton',
                        initiate: changeBodySize,
                        start: function() {
                            MaximizeWrapper(function() {
                                if(pizzabtn.moved == false) {
                                    pizzabtn.dragAnimate();
                                };
                                pizzabtn.moved = true;
                                //hide hint
                                if(pizzabtn.hintTextActive) {
                                    pizzabtn.hideHint();
                                }
                                // show close button
								if (params.NeverClose==false) {
									closeButton.show();
								};
                                SendStatisticsData("Moved", 1);

                                //MinimizeWrapper(function(){}, params.MinimizeWrapperTime);
                            });
                        },
                        drag: function() {
                            MaximizeWrapper(function() {

                            var pizzabtnRect = pizzabtn[0].getBoundingClientRect();
                            var closeButtonRect = closeButton[0].getBoundingClientRect();

                            if ((pizzabtnRect.top + pizzabtnRect.height) > $(window).height()) {
                            }

                            var overlap = !(pizzabtnRect.right < closeButtonRect.left || pizzabtnRect.left > closeButtonRect.right || pizzabtnRect.bottom < closeButtonRect.top || pizzabtnRect.top > closeButtonRect.bottom);
                            if(overlap && closeButtonRect.width !== 0) {
                                if(!overlaped) {
                                    closeButton.overlayActive();
                                    overlaped = true;
                                }
                            } else {
                                if(overlaped) {
                                    closeButton.overlayUnactive();
                                    overlaped = false;
                                }
                            }
                            });
                        },
                        stop: function() {
                            //MinimizeWrapper();

                            if(!pizzabtn.moved) {
                                //if button clicked                                
                                MaximizeWrapper(function() {
                                    onButtonTap();
                                });
                            } else {
                                MinimizeWrapper(function() {}, params.MinimizeWrapperTime);

                                if(overlaped) {
                                    SendStatisticsData("Closed", 1);
                                    SendStatisticsData("Hidded", 1);
                                    pizzabtn.hide();
                                } else {
                                    pizzabtn.undragAnimate();
                                };
                            }
                            closeButton.hide();
                            pizzabtn.moved = false;
                            overlaped = false;
                        }
                    });

                    function onButtonTap() {
                        //console.log("button tap");
                        //alert("button tap");
                        //MaximizeWrapper(function() {
                        console.log("button tap 1");
                        MaximizeWrapper(function() { console.log("maximize tap"); });

                        //$.fancybox.hideLoading();

                        var isMobileLandscape = (isLandscape() && window.jscd.mobile),
                            position          = pizzabtn.position(),
                            buttonTop         = position.top,
                            buttonLeft        = position.left,
                            winWidth          = window.innerWidth,
                            winHeight         = window.innerHeight,
                            finishTop         = '0px',
                            finishLeft        = '0px',
                            widthCenter       = (winWidth + params.ButtonSize.W) / 2,
                            heightCenter      = (winHeight + params.ButtonSize.H) / 2;

                        // top or bottom
                        if(heightCenter <= buttonTop) {
                            finishTop = (winHeight - params.ButtonSize.H) + 'px';
                        }
                        // left or right
                        if(widthCenter <= buttonLeft) {
                            finishLeft = (winWidth - params.ButtonSize.W) + 'px';
                        }

                        if ((params.ContentInsets.T < 0) || (params.ContentInsets.B < 0) || (params.ContentInsets.L < 0) || (params.ContentInsets.R < 0)) {
                            var margins = (isMobileLandscape)
                                ? [params.ButtonSize.H/4, params.ButtonSize.H/4 +5, params.ButtonSize.H/4, params.ButtonSize.H/4 +5]
                                : [params.ButtonSize.H+5, params.ButtonSize.H/2, params.ButtonSize.H+5, params.ButtonSize.H/2];

                            if ((window.jscd.mobile) && (params.ButtonSize.H > 70))
                            {
                                margins = [params.ButtonSize.H/8, params.ButtonSize.H/8, params.ButtonSize.H/8, params.ButtonSize.H/8];
                            } else {
							    if (params.ButtonSize.H > 70) {
								    margins = [70, 70, 70, 70];
							    };
						    };
                        } else {
                            var margins = [params.ContentInsets.T, params.ContentInsets.R, params.ContentInsets.B, params.ContentInsets.L];
                        }

                        var positionObj = {
                            property: (isMobileLandscape) ? "left" : "top",
                            currentValue: (isMobileLandscape) ? buttonLeft : buttonTop,
                            finishValue: (isMobileLandscape) ? finishLeft : finishTop
                        }

                        var InitLeft = $("#pizzabtn").offset().left;
                        var InitTop = $("#pizzabtn").offset().top;

                        // send content showed stat
                        SendStatisticsData("ContentShowed", 1);

                        $.pep.toggleAll(false);

						var fancyboxParams = {
                            href: params.ContentURL,
                            sandbox: "allow-same-origin allow-scripts allow-popups allow-forms",
                            type: 'iframe',

                            autoCenter: true,
                            titlePosition: 'inside',
                            scrolling: 'no',
                            margin: margins,
                            scrollOutside: true,
                            //openEffect: 'none',
                            //closeEffect: 'none',
                            speedIn: 1000,
                            openSpeed: 1000,
                            closeSpeed: 0,
                            speedOut: 0,
                            openOpacity: false,
                            //closeEffect: 'none',
                            //autoResize: true,
                            //autoScale: true,
                            padding: "0px",
                            height: "100%",
                            minWidth: 100,
                            minHeight: 100,
							//autoscale: true,
                            iframe: {
                                sandbox: "allow-same-origin allow-scripts allow-popups allow-forms",
                                preload: false,
                                scrolling: "no"
                            },
                            helpers: {
                                overlay: {
                                  locked: false,
                                  speedIn: 0,
		                          speedOut: 0,   // duration of fadeOut animation
		                          showEarly: true,  // indicates if should be opened immediately or wait until the content is ready
                                },
                                title : { type : 'inside' }
                            },
                            beforeLoad: function() {
                                
                                $("#hintText").hide();

                                $(".fancybox-iframe").first().attr("sandbox", "allow-same-origin allow-scripts allow-popups allow-forms");
                                //$("").first().css

                                pizzabtn.css(positionObj.property, positionObj.finishValue);
                                if (positionObj.property=='top') {
                                    pizzabtn.css('left', InitLeft+'px');
                                } else {
                                    pizzabtn.css('top', InitTop+'px');
                                }

                                if(window.jscd.os === "iOS") {
                                    $(document.body).bind("touchmove", function(e) {
                                        e.preventDefault();
                                        e.stopPropagation();
                                        e.returnValue = false; // ie
                                    });
                                }
                                $('html').css("overflow", "hidden");
                            },
                            afterShow: function() {
                                var pizzabtn_wrapper = $("#pizzabtn_wrapper");
                                var opts = {
                                    width: $(window).width(),
                                    height: $(window).height(),
                                    position: "fixed"
                                };
                                console.log(opts);
                                pizzabtn_wrapper.css(opts);

                                $(".fancybox-iframe").first().attr("sandbox", "allow-same-origin allow-scripts allow-popups allow-forms");
                                $(".fancybox-iframe").first().contents().find("html").css("visibility", "visible !important");
                                $(".fancybox-iframe").first().attr("scrolling", "no");
                                $(".fancybox-iframe").first().width($(".fancybox-inner").first().width());
                                

                                pizzabtn.bind("click", $.fancybox.close);
                            },
                            afterClose: function () {
                                MinimizeWrapper(function(){                                    
                                }, params.MinimizeWrapperTime);
                                if(window.jscd.os === "iOS") {
                                    $(document.body).unbind('touchmove');
                                }
                                $('html').css("overflow", "auto");
                                pizzabtn.unbind('click');
                                $.pep.toggleAll(true);
                                if(closeAfterOrientationChange) {
                                    pizzabtn.center();
                                    closeAfterOrientationChange = false;
                                } else {
                                    pizzabtn.css(positionObj.property, positionObj.currentValue + 'px');
                                }

                                if(params.HideAfterFirstShow == true) {
                                    SendStatisticsData("Closed", 1);
                                    SendStatisticsData("Hidded", 1);
                                    pizzabtn.hide();
                                };
                            }
                        };

                        function formatTitle() {
                            return '<div id="button_fancybox_title">'+ params.VendorText +'</div>';
                        }

                        if ((params.VendorText!=="") && (params.ButtonEnabled===true) && (params.ButtonVisible===true)) {
                            try {
                            fancyboxParams.titleShow = true;
                            fancyboxParams.title = "<style>.fancybox-title-inside-wrap {color: rgba("+params.VendorColor.R+","+params.VendorColor.G+","+params.VendorColor.B+","+params.VendorColor.A+"); text-align: center; } </style><a style='font-family: "+params.VendorTextFont.Family+"; font-size: "+params.VendorTextFont.Size+"px; color: rgba("+params.VendorTextColor.R+","+params.VendorTextColor.G+","+params.VendorTextColor.B+","+params.VendorTextColor.A+")' href='"+params.VendorSite +"' target='_blank'>"+params.VendorText+"</a>";
                            /*fancyboxParams.titleFormat = function () {
                                return '<div id="button_fancybox_title">'+ params.VendorText +'</div>';
                            };*/
                            } catch(ex) { }
                        }

						//params.IsManualSize  =true;
						//params.ContentSize.X = "10%";
						if (params.IsManualSize===true) {
							fancyboxParams.width = params.ContentSize.X;
							fancyboxParams.height = params.ContentSize.Y;
							//fancyboxParams.autoScale = false;
						} else {
						}
						if (params.MaxWidth>0) {
							fancyboxParams.maxWidth = params.MaxWidth;
						};
						if (params.MaxHeight>0) {
							fancyboxParams.maxHeight = params.MaxHeight;
						};

						////console.log("params.OpenExternal - "+params.OpenExternal);
						if (params.OpenExternal===true) {
							MinimizeWrapper(function() {
                                pizzabtn.css(positionObj.property, positionObj.finishValue);
                                if (positionObj.property=='top') {
                                    pizzabtn.css('left', InitLeft+'px');
                                } else {
                                    pizzabtn.css('top', InitTop+'px');
                                }

                                if(window.jscd.os === "iOS") {
                                    $(document.body).bind("touchmove", function(e) {
                                        e.preventDefault();
                                        e.stopPropagation();
                                        e.returnValue = false; // ie
                                    });
                                }

								if(window.jscd.os === "iOS") {
                                    $(document.body).unbind('touchmove');
                                }
                                $('html').css("overflow", "auto");
                                pizzabtn.unbind('click');
                                $.pep.toggleAll(true);

								window.open(params.ContentURL, '_blank');
							}, params.MinimizeWrapperTime);
						} else {

                            var pizzabtn_wrapper = $("#pizzabtn_wrapper");
                            var opts = {
                                width: $(window).width(),
                                height: $(window).height(),
                                position: "fixed"
                            };
                            console.log(opts);
                            pizzabtn_wrapper.css(opts);
                           

							$.fancybox.open(fancyboxParams);
						};

                    //});
                    }
                }
            };

            // XXX STATISTICS
            function SendStat(name, value, probtnId, currentDomain) {
                $.getJSON(serverUrl+"/1/functions/updateUserStatistic?BundleID="+currentDomain+"&Version=1.0&DeviceType=web&CampaignID="+params.CampaignID+"&DeviceUID="+probtnId+"&localDomain="+realDomain+"&Statistic="+"{\"" + name + "\": \"" + value + "\"}&"+"X-ProBtn-Token=b04bb84b22cdacb0d57fd8f8fd3bfeb8ad430d1b&callback=?",
                function(){}).done(function(){}).fail(function(){}).always(function(){});
            }

            ///
            /// Send stats to probtn
            /// <values>
            /// paramName - name for statistics parameter
            /// value - value of this paarameter. Default is 1
            /// custom - if set to 1, this param and it's value will be send as custom stats
            /// </values>
            ///
            function SendStatisticsData(paramName, value, custom) {
                var probtnId = "1234";

                if(paramName == "" || paramName == null) {
                    paramName = "Opened";
                };
                if(value == "" || value == null) {
                    value = 1;
                };
                /*if(probtnId != "" || probtnId != null) {
                    probtnId = "1234";
                };*/
                probtnId = GetDeviceUID();

                if(custom == "" || custom == null) {
                    SendStat(paramName, value, probtnId, currentDomain);
                } else {
                    SendCustomStat(paramName, value, probtnId, currentDomain);
                };
            }

            ///
            /// Function used to send "custom" statistics
            /// for example information about resolution, OS, browser, browser version
            /// This information would be rewriten by last resived data for deviceUID each time when it send to server
            ///
            function SendCustomStat(name, value, probtnId, currentDomain) {
                $.getJSON(serverUrl+"/1/functions/updateCustomStatistic?BundleID="+currentDomain+"&DeviceType=web&CampaignID="+params.CampaignID+"&Version=1.0&DeviceUID="+probtnId+"&localDomain="+realDomain+"&Statistic="+"{\"" + name + "\": \"" + value + "\"}&"+"X-ProBtn-Token=b04bb84b22cdacb0d57fd8f8fd3bfeb8ad430d1b&callback=?",
                function(){}).done(function(){}).fail(function(){}).always(function(){});
            }

            ///
            /// send information about browser version, resolution and some other data
            ///
            function SendBrowserStatsInfo() {
                try {
                    SendStatisticsData("Resolution", jscd.screen, 1);
                    SendStatisticsData("Browser", jscd.browser, 1);
                    SendStatisticsData("BrowserVersion", jscd.browserVersion, 1);
                    SendStatisticsData("OS", jscd.os +' '+ jscd.osVersion, 1);
                } catch(ex) {}
            }
        });
    } else {
        //console.log("IE8 not supported.");
    }

        // XXX CONSTRUCTORS

        // close button constructor
        function initCloseButton() {
            var btn = $('<img/>', {
                id: 'closeButton',
                'src': params.CloseImage,
                'class': 'close_pro_button_normal',
                css: {
                    position: 'fixed',
                    display: 'none'
                }
            }).prependTo('body');

            btn.active = false;
            btn.rect = {};

            btn.css({
                '-webkit-transform': 'translateZ(0)',
                '-moz-transform': 'translateZ(0)',
                '-ms-transform': 'translateZ(0)',
                '-o-transform': 'translateZ(0)',
                'transform': 'translateZ(0)',

                '-webkit-backface-visibility': 'hidden',
                '-moz-backface-visibility': 'hidden',
                '-ms-backface-visibility': 'hidden',
                'backface-visibility': 'hidden',

                '-webkit-perspective': 1000,
                '-moz-perspective': 1000,
                '-ms-perspective': 1000,
                'perspective': 1000,

                'transition-property': 'opacity, width, height, left, top',
                'timing-function': 'linear',

                '-webkit-transition-property': 'opacity, width, height, left, top',
                '-webkit-timing-function': 'linear',

                '-moz-transition-property': 'opacity, width, height, left, top',
                '-moz-timing-function': 'linear',

                '-o-transition-property': 'opacity, width, height, left, top',
                '-o-timing-function': 'linear',
            });

            btn.center = function() {
                var body = $('body');
				var closex = params.ClosePosition.X;
				var closey = params.ClosePosition.Y;
                this.css('top', ($(window).height() - this.height())*closey + 'px'); //(body.innerHeight() - this.height())*closey + $(window).scrollTop() + 'px');
                this.css('left', (body.innerWidth() - this.width())*closex + $(window).scrollLeft() + 'px');
            }

            btn.show = function() {
                var me = this;
                me.center();
                setTimeout(function() {
                    me.stop(true, true).fadeIn(params.CloseShowDuration * 1000);
                }, params.CloseShowDelay * 1000);
            }

            btn.hide = function() {
                var me = this;
                setTimeout(function() {
                    me.stop(true, true).fadeOut(params.CloseHideDuration * 1000);
                }, params.CloseHideDelay * 1000);
            }

            btn.setTransitionDuration = function(duration) {
                var val = duration + 's';
                this.css({
                    'transition-duration': val,
                    '-webkit-transition-duration': val,
                    '-moz-transition-duration': val,
                    '-o-transition-duration': val,
                });
            }

            // Animation when close button become active - change size and opacity
            btn.overlayActive = function() {
                var me = this;
                var position = me.position();
                me.setTransitionDuration(params.CloseActiveDuration);
                setTimeout(function() {
                    me.css({
                        opacity: params.CloseActiveOpacity,
                        width: params.CloseActiveSize.W,
                        height: params.CloseActiveSize.H,
                        left: position.left - ((params.CloseActiveSize.W - params.CloseSize.W)/2),
                        top: position.top - ((params.CloseActiveSize.H - params.CloseSize.H)/2),
                    });
                }, params.CloseActiveDelay * 1000);
            }

            // Animation when button become inactive - restore close button size and opacity
            btn.overlayUnactive = function() {
                var me = this;
                var body = $('body');
				var closex = params.ClosePosition.X;
				var closey = params.ClosePosition.Y;
                var top = ($(window).height() - this.height())*closey + 'px';
                //(body.innerHeight() - closeButton.height())*closey + $(window).scrollTop(); 
                ///+$(window).scrollTop()
                var left = (body.innerWidth() - closeButton.width())*closex + $(window).scrollLeft(); ///+$(window).scrollLeft()

                me.setTransitionDuration(params.CloseUnactiveDuration);
                setTimeout(function() {
                    var options = {
                        opacity: params.CloseOpacity,
                        width: params.CloseSize.W,
                        height: params.CloseSize.H,
                        left: left,
                        top: top,
                    };

                    me.css(options);
                }, params.CloseUnactiveDelay * 1000);
            };

            btn.setTransitionDuration(params.CloseActiveDuration);

            btn.center();

            return btn;
        }

        function MinimizeWrapper(callback1, time) {
            //console.log("MinimizeWrapper");
            var callback = callback1;
            function minimize() {
                    var pizzabtn_wrapper = $("#pizzabtn_wrapper");
                    var opts = {
                                width: "auto",
                                height: "auto",
                                position: "fixed"
                    };

                    if ((params.TrackingLink!==null) && (params.TrackingLink!==null) && (params.TrackingLink!=="")) {
                        opts['background'] = 'url('+params.TrackingLink+') no-repeat';
                        //console.log(opts);
                    }

                    try {
                        $.pep.toggleAll(false);
                        pizzabtn_wrapper.css(opts);
                        $.pep.toggleAll(true);
                    } catch(ex) { 
                        //console.log(ex);
                        pizzabtn_wrapper.css(opts);
                    }

                if ((callback!==null) && (callback!==undefined)) {
                    callback();
                }
            }
              
            if (time!==null) {
                setTimeout(minimize, time)
            } else {
                minimize();                
            }            
        }

        ///
        ///
        ///
        function MaximizeWrapper(callback) {
            //console.log("MaximizeWrapper");
            var pizzabtn_wrapper = $("#pizzabtn_wrapper");
            var opts = {
                width: $(window).width(),
                height: $(window).height(),
                position: "fixed"
            };

            if ((params.TrackingLink!==null) && (params.TrackingLink!==null) && (params.TrackingLink!=="")) {
                opts['background'] = 'url('+params.TrackingLink+') no-repeat';
                //console.log(opts);
            }

            pizzabtn_wrapper.css(opts);

            try {
                if (($("#pizzabtn").offset().left - $(window).scrollLeft())  > pizzabtn_wrapper.width()) {
                    ////console.log("change button left");
                    var newleft = pizzabtn_wrapper.width() - $("#pizzabtn").width();
                    $("#pizzabtn").css({ left: newleft+'px' });
                };
            } catch(ex) {};
            try {
                if (($("#pizzabtn").offset().top - $(window).scrollTop()) > pizzabtn_wrapper.height()) {
                    ////console.log("change button top");
                    var newtop = pizzabtn_wrapper.height() - $("#pizzabtn").height();
                    $("#pizzabtn").css({ top: newtop+'px' });
                };
            } catch(ex) {};

            try {
                callback();
            }catch(ex) {};
        }

        // pizza button constructor
        function initPizzaButton() {
            var pizzabtn_wrapper = $("<div/>", {
                    id: "pizzabtn_wrapper"
                }).prependTo('body');            

            $("body").on('click', "#pizzabtn_wrapper", function() {
               //console.log("pizzabtn_wrapper clicked");
               MinimizeWrapper(function() {}, 0); 
            });

            var opts = {
                //width: $(window).width(),
                //height: $(window).height(),
                width: "auto",
                height: "auto",
                position: "fixed"
            };

            if ((params.TrackingLink!==null) && (params.TrackingLink!==null) && (params.TrackingLink!=="")) {
                opts['background'] = 'url('+params.TrackingLink+') no-repeat';
            }
            pizzabtn_wrapper.css(opts);
			
			/*if ((window.jscd.mobile)) {				
			} else {
				//.fancybox-inner
				$("<style>")
					.prop("type", "text/css")
					.html(".fancybox-inner { overflow: hide !important; }")
					.appendTo("head");
				//hide second scroll
			}*/

            var btn = $("#pizzabtn");
            if(btn.length === 0) {
                btn = $("<div/>", {
                    id: "pizzabtn"
                }).prependTo(pizzabtn_wrapper);
            };
            btn.addClass("pizzabtn_normal");
            btn.css({
                'display': 'none',

                '-webkit-transform': 'translateZ(0)',
                '-moz-transform': 'translateZ(0)',
                '-ms-transform': 'translateZ(0)',
                '-o-transform': 'translateZ(0)',
                'transform': 'translateZ(0)',

                '-webkit-backface-visibility': 'hidden',
                '-moz-backface-visibility': 'hidden',
                '-ms-backface-visibility': 'hidden',
                'backface-visibility': 'hidden',

                '-webkit-perspective': 1000,
                '-moz-perspective': 1000,
                '-ms-perspective': 1000,
                'perspective': 1000,

                '-webkit-transition': 'top, left '+params.buttonAnimationTimeAfterFancybox+'ms linear',
                '-moz-transition': 'top, left '+params.buttonAnimationTimeAfterFancybox+'ms linear',
                '-ms-transition': 'top, left '+params.buttonAnimationTimeAfterFancybox+'ms linear',
                '-o-transition': 'top, left '+params.buttonAnimationTimeAfterFancybox+'ms linear',
                'transition': 'top, left '+params.buttonAnimationTimeAfterFancybox+'ms linear',
				'width': params.ButtonSize.W,
                'height': params.ButtonSize.H
            });

            // add image
            var pizzabtnImg = $("<img/>", {
                id: "pizzabtnImg",
                src: params.ButtonImage,
                css: {
                    'width': params.ButtonSize.W,
                    'height': params.ButtonSize.H,
                    'opacity': params.ButtonOpacity,

                    'transition-property': 'opacity, width, height',
                    'timing-function': 'linear',

                    '-webkit-transition-property': 'opacity, width, height',
                    '-webkit-timing-function': 'linear',

                    '-moz-transition-property': 'opacity, width, height',
                    '-moz-timing-function': 'linear',

                    '-o-transition-property': 'opacity, width, height',
                    '-o-timing-function': 'linear',
                }
            }).appendTo(pizzabtn);

            // add hint text
            var hintText = $("<span/>", {
                id: "hintText",
                css: {
                    opacity: 0,

                    'transition-property': 'opacity',
                    'timing-function': 'linear',

                    '-webkit-transition-property': 'opacity',
                    '-webkit-timing-function': 'linear',

                    '-moz-transition-property': 'opacity',
                    '-moz-timing-function': 'linear',

                    '-o-transition-property': 'opacity',
                    '-o-timing-function': 'linear',

                    'transition-duration': params.HintShowDuration + 's',
                    '-webkit-transition-duration': params.HintShowDuration + 's',
                    '-moz-transition-duration': params.HintShowDuration + 's',
                    '-o-transition-duration': params.HintShowDuration + 's',
                },
                html: params.HintText.replace(/ /g,"&nbsp;")
            }).appendTo(pizzabtn);
            pizzabtn.hintTextActive = false;



            MinimizeWrapper(function() {}, params.MinimizeWrapperTime);

            hintText.makeInvisible = function() {
                this.css({
                    'transition-duration': params.HintHideDuration + 's',
                    '-webkit-transition-duration': params.HintHideDuration + 's',
                    '-moz-transition-duration': params.HintHideDuration + 's',
                    '-o-transition-duration': params.HintHideDuration + 's',
                });
                this.css('opacity', 0);
            }

            btn.center = function() {
                var body = $('#pizzabtn_wrapper');
                this.css('top', (body.innerHeight() - this.height())/2 + $(window).scrollTop() + 'px');
                this.css('left', (body.innerWidth() - this.width())/2 + $(window).scrollLeft() + 'px');
            }

            btn.show = function() {
                var me = this;
                setTimeout(function() {
                    me.stop(true, true).fadeIn(params.ButtonShowDuration * 1000);
                }, params.ButtonShowDelay * 1000);
            }

            btn.hide = function() {
                var me = jQuery("#pizzabtn");
                setTimeout(function() {
                    me.stop(true, true).fadeOut(params.ButtonHideDuration * 1000);
                }, params.ButtonHideDelay * 1000);
            }

            //aditional actions
            window.proBtn  = {};
            window.proBtn.hide = btn.hide;
            window.proBtn.hideContent = function() {
                $.fancybox.close();
            };
            window.proBtn.performAction = function() {
                if (params.CampaignID!==null) {
                    $.getJSON(serverUrl+"/1/functions/performAction?DeviceType=web&DeviceUID="+GetDeviceUID()+"&X-ProBtn-Token="+XProBtnToken+"&CampaignID="+params.CampaignID+"&random="+Math.random()+"&callback=?",
                        function(data) {
                            //console.log(data);
                        }
                    );
                }
            };

            btn.dragAnimate = function() {
                pizzabtnImg.attr("src", params.ButtonDragImage);
                setTimeout(function() {
                    pizzabtnImg.css({
                        'transition-duration': params.ButtonDragDuration + 's',
                        '-webkit-transition-duration': params.ButtonDragDuration + 's',
                        '-moz-transition-duration': params.ButtonDragDuration + 's',
                        '-o-transition-duration': params.ButtonDragDuration + 's',
                    });
                    pizzabtnImg.css({
                        opacity: params.ButtonDragOpacity,
                        width: params.ButtonDragSize.W,
                        height: params.ButtonDragSize.H
                    });

                }, params.ButtonDragDelay * 1000);
            }

            btn.undragAnimate = function() {
                pizzabtnImg.attr("src", params.ButtonImage);
                setTimeout(function() {
                    pizzabtnImg.css({
                        'transition-duration': params.ButtonUndragDuration + 's',
                        '-webkit-transition-duration': params.ButtonUndragDuration + 's',
                        '-moz-transition-duration': params.ButtonUndragDuration + 's',
                        '-o-transition-duration': params.ButtonUndragDuration + 's',
                    });
                    pizzabtnImg.css({
                        opacity: params.ButtonOpacity,
                        width: params.ButtonSize.W,
                        height: params.ButtonSize.H
                    });

                    //MinimizeWrapper();

                }, params.ButtonUndragDelay * 1000);
            }

            btn.showHint = function() {
                var me = this;
                setTimeout(function() {
                    hintText.css(hintTextStyle);
                    me.hintTextActive = true;

                    var textOffset = (($('#hintText').width() - params.ButtonSize.W)/2);
                    $("#hintText").css("margin-left", "-"+textOffset+"px");

                }, params.HintLaunchDelay * 1000);
            }

            btn.hideHint = function() {
                var me = this;
                hintText.makeInvisible();
                setTimeout(function() {
                    me.animateDuringHintHide();
                }, 100)
                me.hintTextActive = false;
            }

            btn.hideHintDelay = function() {
                setTimeout(function() {
                    hintText.makeInvisible();
                }, params.HintLaunchDuration * 1000);
            }

            btn.animateDuringHintHide = function() {
                var me = this;
                var hintWidth = hintText.outerWidth();
                var diffWidth = (hintWidth - params.ButtonSize.W) / 2;
                if(diffWidth > 0) {
                    me.css({
                        width: params.ButtonSize.W,
                        height: params.ButtonSize.H,
                        left: me.position().left + diffWidth
                    });
                }
            }

            try {
                var top = (window.innerHeight - (params.ButtonSize.H /2)) * (params.ButtonPosition.Y);
                var left = ($('body').innerWidth() - (params.ButtonSize.W /2)) * (params.ButtonPosition.X) + $(window).scrollLeft() + 'px';
                btn.css({
                    left: left,
                    top: top,
                    position: 'absolute'
                });
            } catch(ex) {}

            changeBodySize();

            return btn;
        }
}
})(jQuery);
