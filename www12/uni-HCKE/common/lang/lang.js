import Vue from 'vue'
import VueI18n from 'vue-i18n'
Vue.use(VueI18n)
import zh from './zh'
import en from './en'
import jp from './jp'
import hk from './hk'
import ar from './ar'
import kr from './kr'
import vn from './vn'
import th from './th'
import de from './de'
import fr from './fr'
import it from './it'
import tr from './tr'
import pt from './pt'
let locale=uni.getStorageSync('lang') || '';
if(locale==''||locale=='zh'){
	locale='en';
	uni.setStorageSync('lang',locale)
}
const i18n=new VueI18n({
	locale:locale,
	messages:{
		zh:zh,
		en:en,
		jp:jp,
		hk:hk,
		ar:ar,
		kr:kr,
		vn: vn,
		de:de,
		fr:fr,
		it:it,
		th:th,
		tr:tr,
		pt:pt
	}
})
export default i18n