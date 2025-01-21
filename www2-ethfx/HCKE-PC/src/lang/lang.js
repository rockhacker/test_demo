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
import it from './it'
import fr from './fr'
import de from './de'
import ru from './ru'
import tr from './tr'
import spa from './spa'
let lang=localStorage.getItem('lang') || '';
if(lang==''||lang=='zh'){
	lang='hk';
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
		it: it,
		fr: fr,
		de: de,
		ru:ru,
		tr:tr,
		spa:spa
	}
})
export default i18n