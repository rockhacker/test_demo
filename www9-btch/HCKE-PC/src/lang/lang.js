import Vue from 'vue'
import VueI18n from 'vue-i18n'
Vue.use(VueI18n)
import zh from './zh'
import en from './en'
import jp from './jp'
import hk from './hk'
import kr from './kr'
import vn from './vn'
import ar from './ar'
import th from './th'


import ru from './ru'
import fr from './fr'
import de from './de'
import tr from './tr'
import it from './it'
import spa from './spa'

let lang=localStorage.getItem('lang') || '';
if(lang==''){
	lang='en';
	localStorage.setItem('lang',lang)
}
const i18n=new VueI18n({
	locale:lang,
	messages:{
		jp: jp,
		zh: zh,
		en: en,
		hk: hk,
		kr: kr,
		vn: vn,
		ar: ar,
		th: th,
		
		de: de,
		ru: ru,
		fr: fr,
		tr: tr,
		it: it,
		spa: spa,
	}
})
export default i18n