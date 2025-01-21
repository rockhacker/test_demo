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
import hi from './hi'
import ru from './ru'
import tr from './tr'
import spa from './spa'
let locale=uni.getStorageSync('lang') || '';
if(locale==''){
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
		hi:hi,
		ru:ru,
		tr:tr,
		spa:spa
	}
})
export default i18n