<?php
$arrText = array(
	"com" => array(
		"tabs" => array("Consenso","Informazione su cookie"),
		"btns" => array("Accetta tutti","Rifiuta"),
		"texts" => array(
			array(
				"title" => "Questo sito web utilizza i cookie",
				"text" => "Utilizziamo i cookie per personalizzare contenuti ed annunci, per fornire funzionalità dei social media e per analizzare il nostro traffico. Condividiamo inoltre informazioni sul modo in cui utilizza il nostro sito con i nostri partner che si occupano di analisi dei dati web, pubblicità e social media, i quali potrebbero combinarle con altre informazioni che ha fornito loro o che hanno raccolto dal suo utilizzo dei loro servizi."
			),
			array(
				"text" => "I cookie sono piccoli file di testo che possono essere utilizzati dai siti web per rendere più efficiente l'esperienza per l'utente.<br><br>La legge afferma che possiamo memorizzare i cookie sul suo dispositivo se sono strettamente necessari per il funzionamento di questo sito. Per tutti gli altri tipi di cookie abbiamo bisogno del suo permesso.<br><br>Questo sito utilizza diversi tipi di cookie. Alcuni cookie sono collocate da servizi di terzi che compaiono sulle nostre pagine.<br><br>In qualsiasi momento è possibile modificare o revocare il proprio consenso dalla Dichiarazione dei cookie sul nostro sito Web.<br><br>Scopra di più su chi siamo, come può contattarci e come trattiamo i dati personali nella nostra Informativa sulla privacy.<br><br>Specifica l’ID del tuo consenso e la data di quando ci hai contattati per quanto riguarda il tuo consenso.<br><br><a href='https://www.myarredo.com/it/terms-of-use/'>Informativa sulla privacy</a>"
			)
		),
	),
	"uk" => array(
		"tabs" => array("Consent","Information about cookies"),
		"btns" => array("Accept all","Decline"),
		"texts" => array(
			array(
				"title" => "This website uses cookies",
				"text" => "We use cookies to personalize content and ads, to provide social media features and to analyze our traffic. We also share information about how you use our site with our web analytics, advertising and social media analytics partners, who may combine it with other information you have provided to them or which they have collected from your use of their services."
			),
			array(
				"text" => "Cookies are small text files that can be used by websites to make the user experience more efficient.<br><br>The law states that we can store cookies on your device if they are strictly necessary for the operation of this site. For all other types of cookies we need your permission.<br><br>This site uses different types of cookies. Some cookies are placed by third party services that appear on our pages.<br><br>You can change or withdraw your consent from the Cookie Declaration on our website at any time.<br><br>Find out more about who we are, how you can contact us and how we handle personal data in our Privacy Policy.<br><br>Specify your consent ID and the date when you contacted us regarding your consent.<br><br><a href='https://www.myarredo.uk/terms-of-use/'>Privacy Policy</a>"
			)
		),
	),
    "de" => array(
        "tabs" => array("Zustimmung","Informationen zu Cookies"),
        "btns" => array("Akzeptiere alle","Ablehnen"),
        "texts" => array(
            array(
                "title" => "Diese Website verwendet Cookies",
                "text" => "Wir verwenden Cookies, um Inhalte und Anzeigen zu personalisieren, Funktionen für soziale Medien bereitzustellen und unseren Datenverkehr zu analysieren. Wir geben auch Informationen darüber, wie Sie unsere Website nutzen, an unsere Webanalyse-, Werbe- und Analysepartner für soziale Medien weiter, die diese möglicherweise mit anderen Informationen kombinieren, die Sie ihnen zur Verfügung gestellt haben oder die sie aus Ihrer Nutzung ihrer Dienste gesammelt haben."
            ),
            array(
                "text" => "Cookies sind kleine Textdateien, die von Websites verwendet werden können, um die Benutzererfahrung effizienter zu gestalten.<br><br>Das Gesetz besagt, dass wir Cookies auf Ihrem Gerät speichern können, wenn sie für den Betrieb dieser Website unbedingt erforderlich sind. Für alle anderen Arten von Cookies benötigen wir Ihre Zustimmung.<br><br>Diese Website verwendet verschiedene Arten von Cookies. Einige Cookies werden von Drittanbietern platziert, die auf unseren Seiten erscheinen.<br><br>Sie können Ihre Einwilligung jederzeit von der Cookie-Erklärung auf unserer Website ändern oder widerrufen.<br><br>Erfahren Sie in unserer Datenschutzerklärung mehr darüber, wer wir sind, wie Sie uns kontaktieren können und wie wir mit personenbezogenen Daten umgehen.<br><br>Geben Sie Ihre Zustimmungs-ID und das Datum an, an dem Sie uns bezüglich Ihrer Zustimmung kontaktiert haben.<br><br><a href='https://www.myarredo.de/terms-of-use/'>Datenschutz-Bestimmungen</a>"
            )
        ),
    ),
    "fr" => array(
        "tabs" => array("Consentement","Informations sur les cookies"),
        "btns" => array("Accepter tout","Déclin"),
        "texts" => array(
            array(
                "title" => "Ce site web utilise des cookies",
                "text" => "Nous utilisons des cookies pour personnaliser le contenu et les publicités, pour fournir des fonctionnalités de médias sociaux et pour analyser notre trafic. Nous partageons également des informations sur la façon dont vous utilisez notre site avec nos partenaires d'analyse Web, de publicité et d'analyse des médias sociaux, qui peuvent les combiner avec d'autres informations que vous leur avez fournies ou qu'ils ont collectées lors de votre utilisation de leurs services."
            ),
            array(
                "text" => "Les cookies sont de petits fichiers texte qui peuvent être utilisés par les sites Web pour rendre l'expérience utilisateur plus efficace.<br><br>La loi stipule que nous pouvons stocker des cookies sur votre appareil s'ils sont strictement nécessaires au fonctionnement de ce site. Pour tous les autres types de cookies, nous avons besoin de votre autorisation.<br><br>Ce site utilise différents types de cookies. Certains cookies sont placés par des services tiers qui apparaissent sur nos pages.<br><br>Vous pouvez à tout moment modifier ou retirer votre consentement à la déclaration relative aux cookies sur notre site Web.<br><br>Découvrez qui nous sommes, comment vous pouvez nous contacter et comment nous traitons les données personnelles dans notre politique de confidentialité.<br><br>Spécifiez votre ID de consentement et la date à laquelle vous nous avez contactés concernant votre consentement.<br><br><a href='https://www.myarredo.fr/terms-of-use/'>Politique de confidentialité</a>"
            )
        ),
    ),
);

$domain = DOMAIN_TYPE;

if (!isset($arrText[$domain])) return '';
?>
<style type="text/css">
    .cookie-agreement-wrapper{
        display: flex;
        position: fixed;
        bottom: 0;
        background: #fff;
        width: 100%;
        z-index: 10000;
        display: none;
    }
    .container-wrap{
        max-width: 1600px;
        margin: 0 auto;
    }
    .cookie-agreement-body{
        padding: 10px 0;
    }
    .cookie-agreement-tabs{
        display: flex;
    }
    .cookie-agreement-tab{
        border-bottom: 2px solid #c5c5c5;
        padding-right: 20px;
        padding-left: 10px;
        padding: 0 20px 5px 10px;
        cursor: pointer;
    }
    .cookie-agreement-tab-active{
        border-bottom: 2px solid #448339;
    }
    .cookie-agreement-info-wrapper{
        display: flex;
        padding-top: 10px;
        justify-content: space-between;
    }
    .cookie-agreement-info{
        font-size: 14px;
        line-height: 22px;
        font-family: 'Open Sans';
    }
    .cookie-agreement-tab-info-title{
        font-weight: 700;
    }
    .cookie-agreement-btns{
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 0 10px;
    }
    .cookie-agreement-btn{
        font-size: 13px;
        line-height: 12px;
        text-transform: uppercase;
        width: 152px;
        height: 34px;
        cursor: pointer;
        border: 1px solid #448339;
    }
    .cookie-agreement-btn-accept{
        background: #448339;
        color: #FFFFFF
    }
    .cookie-agreement-btn-decline{
        background: #fff;
        color: #535351;
    }
    .cookie-agreement-tab-info{
        display: none;
    }
    .cookie-agreement-tab-info-active{
        display: block;
    }
    @media(max-width:1600px){
        .cookie-agreement-body{
            padding: 10px;
        }
    }
    @media(max-width:1000px){
        .cookie-agreement-btns{
            flex-direction: column;
        }
    }
    @media(max-width:767px){
        .cookie-agreement-info-wrapper{
            flex-direction: column;
            row-gap: 10px;
            max-height: 50vh;
        }
        .cookie-agreement-info{
        	overflow: scroll;
        }
        .cookie-agreement-btns{
            flex-direction: row;
        }
    }
</style>
<div class="cookie-agreement-wrapper">
    <div class="cookie-agreement-body container-wrap"> 
        <div class="cookie-agreement-tabs">
            <div class="cookie-agreement-tab cookie-agreement-tab-active" data-tab="1"><?=$arrText[$domain]['tabs'][0]?></div>
            <div class="cookie-agreement-tab" data-tab="2"><?=$arrText[$domain]['tabs'][1]?></div>
        </div>
    
        <div class="cookie-agreement-info-wrapper">
            <div class="cookie-agreement-info">
                <div class="cookie-agreement-tab-info cookie-agreement-tab-info-active" data-tab-info="1">
                    <div class="cookie-agreement-tab-info-title"><?=$arrText[$domain]['texts'][0]['title']?></div>
                    <div class="cookie-agreement-tab-info-text"><?=$arrText[$domain]['texts'][0]['text']?></div>
                </div>
                <div class="cookie-agreement-tab-info" data-tab-info="2">
                    <div class="cookie-agreement-tab-info-text"><?=$arrText[$domain]['texts'][1]['text']?></div>
                </div>
            </div>
    
            <div class="cookie-agreement-btns">
                <button class="cookie-agreement-btn cookie-agreement-btn-accept"><?=$arrText[$domain]['btns'][0]?></button>
                <button class="cookie-agreement-btn cookie-agreement-btn-decline"><?=$arrText[$domain]['btns'][1]?></button>
            </div>
        </div>
    </div>
</div>
<script src="/js/js.cookie.js"></script>
<script type="text/javascript">
    (function () {
    	var d = document;
    	var w = window;
    	function cookieAgreement(){
			if(!Cookies.get('cookie_agree')){//!$.cookie('cookie_agree')
	            setTimeout(function(){
	                $('.cookie-agreement-wrapper').slideToggle(500);
	            }, 3000);        
	        }

	        $('.cookie-agreement-btn-accept').click( function () {
	            //$.cookie('cookie_agree', '1', { expires: 30, path: '/' });
	            cookieDomain = location.hostname;
	            Cookies.set('cookie_agree', 1, {path: '/', domain: cookieDomain, expires: 30});
	            console.log('get',Cookies.get('cookie_agree'));
	            $('.cookie-agreement-wrapper').slideToggle(500);
	        });
	        
	        $('.cookie-agreement-btn-decline').click( function () {
                cookieDomain = location.hostname;
                Cookies.set('cookie_agree', 2, {path: '/', domain: cookieDomain, expires: 30});
                console.log('get',Cookies.get('cookie_agree'));
	            $('.cookie-agreement-wrapper').slideToggle(500);
	        });
	        
	        $('[data-tab]').on('click', function(){
	            $('.cookie-agreement-tab').toggleClass('cookie-agreement-tab-active');
	            $('.cookie-agreement-tab-info').toggleClass('cookie-agreement-tab-info-active');
	        });
    	}
        if (d.readyState == 'complete') {
	        cookieAgreement();
	    } else {
	        if (w.attachEvent) {
	            w.attachEvent('onload', cookieAgreement);
	        } else {
	            w.addEventListener('load', cookieAgreement, false);
	        }
	    }
    })();
</script>