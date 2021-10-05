/*!
 *  Lang.js for Laravel localization in JavaScript.
 *
 *  @version 1.1.10
 *  @license MIT https://github.com/rmariuzzo/Lang.js/blob/master/LICENSE
 *  @site    https://github.com/rmariuzzo/Lang.js
 *  @author  Rubens Mariuzzo <rubens@mariuzzo.com>
 */
(function(root,factory){"use strict";if(typeof define==="function"&&define.amd){define([],factory)}else if(typeof exports==="object"){module.exports=factory()}else{root.Lang=factory()}})(this,function(){"use strict";function inferLocale(){if(typeof document!=="undefined"&&document.documentElement){return document.documentElement.lang}}function convertNumber(str){if(str==="-Inf"){return-Infinity}else if(str==="+Inf"||str==="Inf"||str==="*"){return Infinity}return parseInt(str,10)}var intervalRegexp=/^({\s*(\-?\d+(\.\d+)?[\s*,\s*\-?\d+(\.\d+)?]*)\s*})|([\[\]])\s*(-Inf|\*|\-?\d+(\.\d+)?)\s*,\s*(\+?Inf|\*|\-?\d+(\.\d+)?)\s*([\[\]])$/;var anyIntervalRegexp=/({\s*(\-?\d+(\.\d+)?[\s*,\s*\-?\d+(\.\d+)?]*)\s*})|([\[\]])\s*(-Inf|\*|\-?\d+(\.\d+)?)\s*,\s*(\+?Inf|\*|\-?\d+(\.\d+)?)\s*([\[\]])/;var defaults={locale:"en"};var Lang=function(options){options=options||{};this.locale=options.locale||inferLocale()||defaults.locale;this.fallback=options.fallback;this.messages=options.messages};Lang.prototype.setMessages=function(messages){this.messages=messages};Lang.prototype.getLocale=function(){return this.locale||this.fallback};Lang.prototype.setLocale=function(locale){this.locale=locale};Lang.prototype.getFallback=function(){return this.fallback};Lang.prototype.setFallback=function(fallback){this.fallback=fallback};Lang.prototype.has=function(key,locale){if(typeof key!=="string"||!this.messages){return false}return this._getMessage(key,locale)!==null};Lang.prototype.get=function(key,replacements,locale){if(!this.has(key,locale)){return key}var message=this._getMessage(key,locale);if(message===null){return key}if(replacements){message=this._applyReplacements(message,replacements)}return message};Lang.prototype.trans=function(key,replacements){return this.get(key,replacements)};Lang.prototype.choice=function(key,number,replacements,locale){replacements=typeof replacements!=="undefined"?replacements:{};replacements.count=number;var message=this.get(key,replacements,locale);if(message===null||message===undefined){return message}var messageParts=message.split("|");var explicitRules=[];for(var i=0;i<messageParts.length;i++){messageParts[i]=messageParts[i].trim();if(anyIntervalRegexp.test(messageParts[i])){var messageSpaceSplit=messageParts[i].split(/\s/);explicitRules.push(messageSpaceSplit.shift());messageParts[i]=messageSpaceSplit.join(" ")}}if(messageParts.length===1){return message}for(var j=0;j<explicitRules.length;j++){if(this._testInterval(number,explicitRules[j])){return messageParts[j]}}var pluralForm=this._getPluralForm(number);return messageParts[pluralForm]};Lang.prototype.transChoice=function(key,count,replacements){return this.choice(key,count,replacements)};Lang.prototype._parseKey=function(key,locale){if(typeof key!=="string"||typeof locale!=="string"){return null}var segments=key.split(".");var source=segments[0].replace(/\//g,".");return{source:locale+"."+source,sourceFallback:this.getFallback()+"."+source,entries:segments.slice(1)}};Lang.prototype._getMessage=function(key,locale){locale=locale||this.getLocale();key=this._parseKey(key,locale);if(this.messages[key.source]===undefined&&this.messages[key.sourceFallback]===undefined){return null}var message=this.messages[key.source];var entries=key.entries.slice();var subKey="";while(entries.length&&message!==undefined){var subKey=!subKey?entries.shift():subKey.concat(".",entries.shift());if(message[subKey]!==undefined){message=message[subKey];subKey=""}}if(typeof message!=="string"&&this.messages[key.sourceFallback]){message=this.messages[key.sourceFallback];entries=key.entries.slice();subKey="";while(entries.length&&message!==undefined){var subKey=!subKey?entries.shift():subKey.concat(".",entries.shift());if(message[subKey]){message=message[subKey];subKey=""}}}if(typeof message!=="string"){return null}return message};Lang.prototype._findMessageInTree=function(pathSegments,tree){while(pathSegments.length&&tree!==undefined){var dottedKey=pathSegments.join(".");if(tree[dottedKey]){tree=tree[dottedKey];break}tree=tree[pathSegments.shift()]}return tree};Lang.prototype._applyReplacements=function(message,replacements){for(var replace in replacements){message=message.replace(new RegExp(":"+replace,"gi"),function(match){var value=replacements[replace];var allCaps=match===match.toUpperCase();if(allCaps){return value.toUpperCase()}var firstCap=match===match.replace(/\w/i,function(letter){return letter.toUpperCase()});if(firstCap){return value.charAt(0).toUpperCase()+value.slice(1)}return value})}return message};Lang.prototype._testInterval=function(count,interval){if(typeof interval!=="string"){throw"Invalid interval: should be a string."}interval=interval.trim();var matches=interval.match(intervalRegexp);if(!matches){throw"Invalid interval: "+interval}if(matches[2]){var items=matches[2].split(",");for(var i=0;i<items.length;i++){if(parseInt(items[i],10)===count){return true}}}else{matches=matches.filter(function(match){return!!match});var leftDelimiter=matches[1];var leftNumber=convertNumber(matches[2]);if(leftNumber===Infinity){leftNumber=-Infinity}var rightNumber=convertNumber(matches[3]);var rightDelimiter=matches[4];return(leftDelimiter==="["?count>=leftNumber:count>leftNumber)&&(rightDelimiter==="]"?count<=rightNumber:count<rightNumber)}return false};Lang.prototype._getPluralForm=function(count){switch(this.locale){case"az":case"bo":case"dz":case"id":case"ja":case"jv":case"ka":case"km":case"kn":case"ko":case"ms":case"th":case"tr":case"vi":case"zh":return 0;case"af":case"bn":case"bg":case"ca":case"da":case"de":case"el":case"en":case"eo":case"es":case"et":case"eu":case"fa":case"fi":case"fo":case"fur":case"fy":case"gl":case"gu":case"ha":case"he":case"hu":case"is":case"it":case"ku":case"lb":case"ml":case"mn":case"mr":case"nah":case"nb":case"ne":case"nl":case"nn":case"no":case"om":case"or":case"pa":case"pap":case"ps":case"pt":case"so":case"sq":case"sv":case"sw":case"ta":case"te":case"tk":case"ur":case"zu":return count==1?0:1;case"am":case"bh":case"fil":case"fr":case"gun":case"hi":case"hy":case"ln":case"mg":case"nso":case"xbr":case"ti":case"wa":return count===0||count===1?0:1;case"be":case"bs":case"hr":case"ru":case"sr":case"uk":return count%10==1&&count%100!=11?0:count%10>=2&&count%10<=4&&(count%100<10||count%100>=20)?1:2;case"cs":case"sk":return count==1?0:count>=2&&count<=4?1:2;case"ga":return count==1?0:count==2?1:2;case"lt":return count%10==1&&count%100!=11?0:count%10>=2&&(count%100<10||count%100>=20)?1:2;case"sl":return count%100==1?0:count%100==2?1:count%100==3||count%100==4?2:3;case"mk":return count%10==1?0:1;case"mt":return count==1?0:count===0||count%100>1&&count%100<11?1:count%100>10&&count%100<20?2:3;case"lv":return count===0?0:count%10==1&&count%100!=11?1:2;case"pl":return count==1?0:count%10>=2&&count%10<=4&&(count%100<12||count%100>14)?1:2;case"cy":return count==1?0:count==2?1:count==8||count==11?2:3;case"ro":return count==1?0:count===0||count%100>0&&count%100<20?1:2;case"ar":return count===0?0:count==1?1:count==2?2:count%100>=3&&count%100<=10?3:count%100>=11&&count%100<=99?4:5;default:return 0}};return Lang});

(function () {
    Lang = new Lang();
    Lang.setMessages({"en.auth":{"failed":"These credentials do not match our records.","throttle":"Too many login attempts. Please try again in :seconds seconds."},"en.messages":{"CSRFTokenError":"The CSRF Token is missing or has expired.","ConsentEmail":"Email:","ConsentName":"Name:","ConsentParticipation":"Consent to participate","ConsentParticipationConsent":"I have read the consent form above and consent to participate.","ConsentPublication":"2. Consent to publish excerpts from recordings","ConsentPublicationConsent":"I consent to excerpts of my recordings being published. (Optional)","ConsentTitle":"Consent Form","DemoTitle":"Demographic questionnaire","EmailForGift":"Pour courir la chance de gagner une carte-cadeau de 100$ chez Les libraires (<a href='www.leslibraires.ca'>www.leslibraires.ca<\/a>), une coop\u00e9rative de librairies ind\u00e9pendantes du Qu\u00e9bec et des Maritimes, veuillez \u00e9crire \u00e0 nouveau votre adresse courriel :","EmailForMap":"Si vous aimeriez recevoir la page web une fois qu'elle est pr\u00eate et disponible en ligne, vous pouvez nous laisser votre adresse courriel :","IndexLink":"Participate in the experiment.","IndexTitle":"DRAWL","Next":"Next page","OK":"OK","Optional":"Optional","RecorderActivateAudioButton":"Activate Audio","RecorderActivateAudioPrompt":"Please click the button below to activate the audio recording functionality in your web browser. If your computer or device has multiple microphone inputs, you may be prompted for which input you wish to activate. If you select the wrong input by mistake, please reload this page and you should be prompted again.","RecorderActivateAudioTitle":"Audio Activation","RecorderAdditionalReadingTitle":"Spontaneous Speech Prompts","RecorderBrowserError":"Sorry, your web browser does not seem to support Web Audio API. The online recorder will not function. Please try upgrading your browser, or try a different browser.","RecorderClose":"Close Recorder","RecorderEncoding":"Please wait while encoding audio. This may take a minute...","RecorderInputLevelLabel":"Input Level Meter","RecorderInstructionsTitle":"Instructions","RecorderMicInputCheckAbove":"Now, check your microphone input levels. Your microphone is activated, but you are not currently being recorded. Try speaking random sentences into the microphone and see how the volume meter reacts (this volume meter also appears in the recording panel). The numbers on the top represent the decibel level, with the quietest sound at -42 dB, and the loudest at 0 dB. As you speak, one or two green bar(s) should appear below indicating what your current recording level is.","RecorderMicInputCheckBelow":"As long as your normal speaking volume is between -24 and -12 (decibels), your current volume is excellent. If your normal speaking is below -36 decibels, you should move closer to the microphone and\/or adjust your settings. If you you are so loud that the input level is reaching 0 (the loudest possible level it can record), please lower your volume or move further away to avoid distortion in the recording.","RecorderMicInputCheckNoSignal":"If you are not seeing any reaction on the level meter, try refreshing this webpage and selecting a different audio input source when activating audio.","RecorderMicInputCheckTitle":"Input Level Check","RecorderNotYet":"Recording not yet submitted","RecorderPlaybackSubmitLabel":"Playback \/ Submit","RecorderReadingTitle":"Reading Sample: Vancouver Dawn","RecorderRec":"Click to Start Recording","RecorderSave":"Submit Recording","RecorderStatusDialogTitle":"Status","RecorderStop":"Recording - Click When Finished","RecorderSubmitBegin":"Beginning recording submission process...","RecorderSubmitConfirm":"Are you sure you wish to submit this recording?","RecorderTestTitle":"Test Recording","RecorderTitle":"Create Recording","RecorderToolTitle":"Recording Tool","RecorderUploadAborted":"Upload Aborted!","RecorderUploadErrorPrefix":"Error: ","RecorderUploadFailed":"Failed to upload to server.","RecorderUploadGettingFileURL":"Getting File URL...","RecorderUploadProgressPrefix":"Upload Progress ","RecorderUploadStarted":"Upload Started...","RecorderUploadSuccessful":"Upload Successful!","RecorderUploadThankYou":"If you still have additional recordings to complete and submit, click OK to return to the interface and proceed with recording them.<br><br>If this was your final recording, thank you for participating! You may now close this window.","SelectLanguageTitle":"Select Language","SomethingWentWrong":"Something went wrong. Please click OK and try submitting your recording again.","Submit":"Submit","WelcomeTitle":"Welcome"},"en.pagination":{"next":"Next &raquo;","previous":"&laquo; Previous"},"en.passwords":{"reset":"Your password has been reset!","sent":"We have emailed your password reset link!","throttled":"Please wait before retrying.","token":"This password reset token is invalid.","user":"We can't find a user with that email address."},"en.questionnaire":{"Age":"Age *","Gender":"Gender *","Location":"Current place of residence *","PoB":"Place of birth","SpokenLanguages":"Other languages that you are fluent in:"},"en.validation":{"accepted":"The :attribute must be accepted.","active_url":"The :attribute is not a valid URL.","after":"The :attribute must be a date after :date.","after_or_equal":"The :attribute must be a date after or equal to :date.","alpha":"The :attribute may only contain letters.","alpha_dash":"The :attribute may only contain letters, numbers, dashes and underscores.","alpha_num":"The :attribute may only contain letters and numbers.","array":"The :attribute must be an array.","attributes":[],"before":"The :attribute must be a date before :date.","before_or_equal":"The :attribute must be a date before or equal to :date.","between":{"array":"The :attribute must have between :min and :max items.","file":"The :attribute must be between :min and :max kilobytes.","numeric":"The :attribute must be between :min and :max.","string":"The :attribute must be between :min and :max characters."},"boolean":"The :attribute field must be true or false.","confirmed":"The :attribute confirmation does not match.","custom":{"attribute-name":{"rule-name":"custom-message"}},"date":"The :attribute is not a valid date.","date_equals":"The :attribute must be a date equal to :date.","date_format":"The :attribute does not match the format :format.","different":"The :attribute and :other must be different.","digits":"The :attribute must be :digits digits.","digits_between":"The :attribute must be between :min and :max digits.","dimensions":"The :attribute has invalid image dimensions.","distinct":"The :attribute field has a duplicate value.","email":"The :attribute must be a valid email address.","ends_with":"The :attribute must end with one of the following: :values.","exists":"The selected :attribute is invalid.","file":"The :attribute must be a file.","filled":"The :attribute field must have a value.","gt":{"array":"The :attribute must have more than :value items.","file":"The :attribute must be greater than :value kilobytes.","numeric":"The :attribute must be greater than :value.","string":"The :attribute must be greater than :value characters."},"gte":{"array":"The :attribute must have :value items or more.","file":"The :attribute must be greater than or equal :value kilobytes.","numeric":"The :attribute must be greater than or equal :value.","string":"The :attribute must be greater than or equal :value characters."},"image":"The :attribute must be an image.","in":"The selected :attribute is invalid.","in_array":"The :attribute field does not exist in :other.","integer":"The :attribute must be an integer.","ip":"The :attribute must be a valid IP address.","ipv4":"The :attribute must be a valid IPv4 address.","ipv6":"The :attribute must be a valid IPv6 address.","json":"The :attribute must be a valid JSON string.","lt":{"array":"The :attribute must have less than :value items.","file":"The :attribute must be less than :value kilobytes.","numeric":"The :attribute must be less than :value.","string":"The :attribute must be less than :value characters."},"lte":{"array":"The :attribute must not have more than :value items.","file":"The :attribute must be less than or equal :value kilobytes.","numeric":"The :attribute must be less than or equal :value.","string":"The :attribute must be less than or equal :value characters."},"max":{"array":"The :attribute may not have more than :max items.","file":"The :attribute may not be greater than :max kilobytes.","numeric":"The :attribute may not be greater than :max.","string":"The :attribute may not be greater than :max characters."},"mimes":"The :attribute must be a file of type: :values.","mimetypes":"The :attribute must be a file of type: :values.","min":{"array":"The :attribute must have at least :min items.","file":"The :attribute must be at least :min kilobytes.","numeric":"The :attribute must be at least :min.","string":"The :attribute must be at least :min characters."},"not_in":"The selected :attribute is invalid.","not_regex":"The :attribute format is invalid.","numeric":"The :attribute must be a number.","password":"The password is incorrect.","present":"The :attribute field must be present.","regex":"The :attribute format is invalid.","required":"The :attribute field is required.","required_if":"The :attribute field is required when :other is :value.","required_unless":"The :attribute field is required unless :other is in :values.","required_with":"The :attribute field is required when :values is present.","required_with_all":"The :attribute field is required when :values are present.","required_without":"The :attribute field is required when :values is not present.","required_without_all":"The :attribute field is required when none of :values are present.","same":"The :attribute and :other must match.","size":{"array":"The :attribute must contain :size items.","file":"The :attribute must be :size kilobytes.","numeric":"The :attribute must be :size.","string":"The :attribute must be :size characters."},"starts_with":"The :attribute must start with one of the following: :values.","string":"The :attribute must be a string.","timezone":"The :attribute must be a valid zone.","unique":"The :attribute has already been taken.","uploaded":"The :attribute failed to upload.","url":"The :attribute format is invalid.","uuid":"The :attribute must be a valid UUID."},"fr.auth":{"failed":"These credentials do not match our records.","throttle":"Too many login attempts. Please try again in :seconds seconds."},"fr.messages":{"CSRFTokenError":"The CSRF Token is missing or has expired.","ConsentEmail":"Email:","ConsentName":"Name:","ConsentParticipation":"D\u00e9claration de consentement du participant.","ConsentParticipationConsent":"I have read the consent form above and consent to participate.","ConsentPublication":"2. Consent to publish excerpts from recordings","ConsentPublicationConsent":"I consent to excerpts of my recordings being published. (Optional)","ConsentTitle":"Formulaire de consentement","DemoTitle":"Questionnaire sociod\u00e9mographique","EmailForGift":"Pour courir la chance de gagner une carte-cadeau de 100$ chez Les libraires (<a href='www.leslibraires.ca'>www.leslibraires.ca<\/a>), une coop\u00e9rative de librairies ind\u00e9pendantes du Qu\u00e9bec et des Maritimes, veuillez \u00e9crire \u00e0 nouveau votre adresse courriel :","EmailForMap":"Si vous aimeriez recevoir la page web une fois qu'elle est pr\u00eate et disponible en ligne, vous pouvez nous laisser votre adresse courriel :","IndexLink":"Participer au projet.","IndexTitle":"Atlas Sonore des Vari\u00e9t\u00e9s de Fran\u00e7ais du Canada","Next":"Page suivante","OK":"Ok","Optional":"Optional","RecorderActivateAudioButton":"Activez l'audio","RecorderActivateAudioPrompt":"Veuillez cliquer sur le bouton ci-dessous pour activer la fonctionnalit\u00e9 d'enregistrement audio dans votre navigateur Web. Si votre ordinateur ou appareil dispose de plusieurs entr\u00e9es microphone, vous serez peut-\u00eatre invit\u00e9(e) \u00e0 indiquer quelle entr\u00e9e vous souhaitez activer. Si vous s\u00e9lectionnez la mauvaise entr\u00e9e par erreur, veuillez recharger cette page et vous devriez \u00eatre invit\u00e9(e) \u00e0 nouveau.","RecorderActivateAudioTitle":"Activation audio","RecorderAdditionalReadingTitle":"ENREGISTREMENT LIBRE","RecorderBrowserError":"D\u00e9sol\u00e9, votre navigateur Web ne semble pas prendre en charge l'API Web Audio. L'enregistrement en ligne ne fonctionnera pas. Veuillez essayer de mettre \u00e0 jour votre navigateur ou essayez un autre navigateur.","RecorderClose":"Close Recorder","RecorderEncoding":"Veuillez patienter pendant l'encodage audio. Cela peut prendre une minute ...","RecorderInputLevelLabel":"Indicateur de niveau d'entr\u00e9e","RecorderInstructionsTitle":"INSTRUCTION ET TEST","RecorderMicInputCheckAbove":"Maintenant, v\u00e9rifiez les niveaux d'entr\u00e9e de votre microphone. Votre microphone est activ\u00e9, mais vous n'\u00eates pas en train d'enregistrer. Essayez de prononcer des phrases au hasard dans le microphone et voyez comment le compteur de volume r\u00e9agit (ce compteur de volume appara\u00eet \u00e9galement dans le panneau d'enregistrement). Les chiffres du haut repr\u00e9sentent le niveau de d\u00e9cibels, avec le son le plus faible \u00e0 -42 dB et le plus fort \u00e0 0 dB. Pendant que vous parlez, une ou deux barres vertes devraient appara\u00eetre en dessous, indiquant votre niveau d'enregistrement actuel.","RecorderMicInputCheckBelow":"Tant que votre volume de parole se situe entre -24 et -12 (d\u00e9cibels), votre volume est excellent. Si votre niveau de parole est inf\u00e9rieur \u00e0 -36 d\u00e9cibels, vous devez vous rapprocher du microphone et\/ou ajuster vos param\u00e8tres. Si vous parlez si fort que le niveau d'entr\u00e9e atteint 0 (le niveau le plus fort possible qu'il puisse enregistrer), veuillez baisser le volume ou vous \u00e9loigner pour \u00e9viter une distorsion dans l'enregistrement.","RecorderMicInputCheckNoSignal":"Si vous ne voyez aucune r\u00e9action sur l'indicateur de niveau, essayez d'actualiser cette page web et s\u00e9lectionnez une autre source d'entr\u00e9e audio lors de l'activation de l'audio.","RecorderMicInputCheckTitle":"V\u00e9rification du niveau d'entr\u00e9e","RecorderNotYet":"L'enregistrement n'a pas encore \u00e9t\u00e9 soumis","RecorderPlaybackSubmitLabel":"Relecture \/ Soumettre","RecorderReadingTitle":"PASSAGE \u00c0 LIRE","RecorderRec":"Cliquez pour commencer l'enregistrement","RecorderSave":"Soumettre l'enregistrement","RecorderStatusDialogTitle":"Statut","RecorderStop":"Enregistrement \u2013 Cliquez lorsque vous avez termin\u00e9","RecorderSubmitBegin":"D\u00e9but du processus de soumission d'enregistrement ...","RecorderSubmitConfirm":"\u00cates-vous s\u00fbr(e) de vouloir soumettre cet enregistrement ?","RecorderTestTitle":"Test Recording","RecorderTitle":"Cr\u00e9er un enregisterment","RecorderToolTitle":"Outil d'enregistrement","RecorderUploadAborted":"T\u00e9l\u00e9chargement annul\u00e9!","RecorderUploadErrorPrefix":"Erreur : ","RecorderUploadFailed":"\u00c9chec du t\u00e9l\u00e9chargement sur le serveur.","RecorderUploadGettingFileURL":"Obtenir l'URL du fichier ...","RecorderUploadProgressPrefix":"Progression du t\u00e9l\u00e9chargement ","RecorderUploadStarted":"Le t\u00e9l\u00e9chargement a commenc\u00e9 ...","RecorderUploadSuccessful":"T\u00e9l\u00e9chargement r\u00e9ussi !","RecorderUploadThankYou":"Si vous avez des enregistrements suppl\u00e9mentaires \u00e0 compl\u00e9ter et \u00e0 soumettre, cliquez sur Ok pour revenir \u00e0 l'interface et proc\u00e9der \u00e0 leur enregistrement.<br><br>S'il s'agissait de votre dernier enregistrement, merci d'avoir particip\u00e9 ! Vous pouvez maintenant fermer cette fen\u00eatre.","SelectLanguageTitle":"Select Language","SomethingWentWrong":"Oups ! Quelque chose s'est mal pass\u00e9. Veuillez cliquer sur Ok et essayez de soumettre votre enregistrement \u00e0 nouveau.","Submit":"Je consens.","WelcomeTitle":"Bienvenue"},"fr.pagination":{"next":"Next &raquo;","previous":"&laquo; Previous"},"fr.passwords":{"reset":"Your password has been reset!","sent":"We have emailed your password reset link!","throttled":"Please wait before retrying.","token":"This password reset token is invalid.","user":"We can't find a user with that email address."},"fr.questionnaire":{"Age":"Age *","Gender":"Gender *","Location":"Current place of residence *","PoB":"Place of birth","SpokenLanguages":"Other languages that you are fluent in:"},"fr.validation":{"accepted":"The :attribute must be accepted.","active_url":"The :attribute is not a valid URL.","after":"The :attribute must be a date after :date.","after_or_equal":"The :attribute must be a date after or equal to :date.","alpha":"The :attribute may only contain letters.","alpha_dash":"The :attribute may only contain letters, numbers, dashes and underscores.","alpha_num":"The :attribute may only contain letters and numbers.","array":"The :attribute must be an array.","attributes":[],"before":"The :attribute must be a date before :date.","before_or_equal":"The :attribute must be a date before or equal to :date.","between":{"array":"The :attribute must have between :min and :max items.","file":"The :attribute must be between :min and :max kilobytes.","numeric":"The :attribute must be between :min and :max.","string":"The :attribute must be between :min and :max characters."},"boolean":"The :attribute field must be true or false.","confirmed":"The :attribute confirmation does not match.","custom":{"attribute-name":{"rule-name":"custom-message"}},"date":"The :attribute is not a valid date.","date_equals":"The :attribute must be a date equal to :date.","date_format":"The :attribute does not match the format :format.","different":"The :attribute and :other must be different.","digits":"The :attribute must be :digits digits.","digits_between":"The :attribute must be between :min and :max digits.","dimensions":"The :attribute has invalid image dimensions.","distinct":"The :attribute field has a duplicate value.","email":"The :attribute must be a valid email address.","ends_with":"The :attribute must end with one of the following: :values.","exists":"The selected :attribute is invalid.","file":"The :attribute must be a file.","filled":"The :attribute field must have a value.","gt":{"array":"The :attribute must have more than :value items.","file":"The :attribute must be greater than :value kilobytes.","numeric":"The :attribute must be greater than :value.","string":"The :attribute must be greater than :value characters."},"gte":{"array":"The :attribute must have :value items or more.","file":"The :attribute must be greater than or equal :value kilobytes.","numeric":"The :attribute must be greater than or equal :value.","string":"The :attribute must be greater than or equal :value characters."},"image":"The :attribute must be an image.","in":"The selected :attribute is invalid.","in_array":"The :attribute field does not exist in :other.","integer":"The :attribute must be an integer.","ip":"The :attribute must be a valid IP address.","ipv4":"The :attribute must be a valid IPv4 address.","ipv6":"The :attribute must be a valid IPv6 address.","json":"The :attribute must be a valid JSON string.","lt":{"array":"The :attribute must have less than :value items.","file":"The :attribute must be less than :value kilobytes.","numeric":"The :attribute must be less than :value.","string":"The :attribute must be less than :value characters."},"lte":{"array":"The :attribute must not have more than :value items.","file":"The :attribute must be less than or equal :value kilobytes.","numeric":"The :attribute must be less than or equal :value.","string":"The :attribute must be less than or equal :value characters."},"max":{"array":"The :attribute may not have more than :max items.","file":"The :attribute may not be greater than :max kilobytes.","numeric":"The :attribute may not be greater than :max.","string":"The :attribute may not be greater than :max characters."},"mimes":"The :attribute must be a file of type: :values.","mimetypes":"The :attribute must be a file of type: :values.","min":{"array":"The :attribute must have at least :min items.","file":"The :attribute must be at least :min kilobytes.","numeric":"The :attribute must be at least :min.","string":"The :attribute must be at least :min characters."},"not_in":"The selected :attribute is invalid.","not_regex":"The :attribute format is invalid.","numeric":"The :attribute must be a number.","password":"The password is incorrect.","present":"The :attribute field must be present.","regex":"The :attribute format is invalid.","required":"The :attribute field is required.","required_if":"The :attribute field is required when :other is :value.","required_unless":"The :attribute field is required unless :other is in :values.","required_with":"The :attribute field is required when :values is present.","required_with_all":"The :attribute field is required when :values are present.","required_without":"The :attribute field is required when :values is not present.","required_without_all":"The :attribute field is required when none of :values are present.","same":"The :attribute and :other must match.","size":{"array":"The :attribute must contain :size items.","file":"The :attribute must be :size kilobytes.","numeric":"The :attribute must be :size.","string":"The :attribute must be :size characters."},"starts_with":"The :attribute must start with one of the following: :values.","string":"The :attribute must be a string.","timezone":"The :attribute must be a valid zone.","unique":"The :attribute has already been taken.","uploaded":"The :attribute failed to upload.","url":"The :attribute format is invalid.","uuid":"The :attribute must be a valid UUID."}});
})();
