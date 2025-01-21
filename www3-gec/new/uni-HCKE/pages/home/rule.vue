<template>
  <view>
      <view class="w-750 overflow-y-auto" v-html="content"></view>

      <navigator  :url="'/pages/mine/invite?code=' + info.invite_code" class="mt-60 mb-30 text-2xl w-690 h-88 rounded-3xl text-center leading-88" style="background: linear-gradient(90deg, #FFB216, #FF9D12);">
          {{$t('financial.msfx')}}
      </navigator>
  </view>
</template>

<script>
import {mapState} from 'vuex'
export default {
    data(){
        return {
            info:{},
            tran:{
      hk:`<body style="tab-interval:21pt;text-justify-trim:punctuation;">
	<!--StartFragment-->
	<div class="Section0" style="layout-grid:15.6000pt;">
		<p class=MsoNormal align=center style="text-autospace:ideograph-numeric;mso-pagination:none;text-align:center;">
			<b><span
					style="mso-spacerun:'yes';font-family:宋体;font-weight:bold;font-size:14.0000pt;mso-font-kerning:1.0000pt;">
					<font face="宋体">邀請返傭活動上線公告</font>
				</span></b><b><span
					style="mso-spacerun:'yes';font-family:宋体;font-weight:bold;font-size:14.0000pt;mso-font-kerning:1.0000pt;">
					<o:p></o:p>
				</span></b></p>
		<p class=MsoNormal style="text-autospace:ideograph-numeric;mso-pagination:none;"><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<font face="宋体">尊敬的</font>
			</span><span
				style="mso-spacerun:'yes';font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;mso-shading:rgb(255,255,255);">GEX</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<font face="宋体">用戶</font>
			</span><span style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal
			style="text-indent:21.0000pt;mso-char-indent-count:2.0000;text-autospace:ideograph-numeric;mso-pagination:none;">
			<span
				style="mso-spacerun:'yes';font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;mso-shading:rgb(255,255,255);">GEX將於2022年06月30日上線邀請返傭活動,</span><span
				style="mso-spacerun:'yes';font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;mso-shading:rgb(255,255,255);">
				邀請返傭活動旨在獎勵GEX的忠實用戶與好友分享在上交易的樂趣。只要邀請的用戶符合返傭條件，邀請人即可獲得最高四代的傭金獎勵。
			</span><span
				style="mso-spacerun:'yes';font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal style="text-autospace:ideograph-numeric;mso-pagination:none;mso-list:l0 level1 lfo1;">
			<![if !supportLists]><span
				style="font-family:宋体;letter-spacing:0.0000pt;font-weight:bold;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;mso-shading:rgb(255,255,255);"><span
					style='mso-list:Ignore;'>一、</span></span>
			<![endif]><b><span
					style="mso-spacerun:'yes';font-family:宋体;letter-spacing:0.0000pt;font-weight:bold;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;mso-shading:rgb(255,255,255);">
					<font face="宋体">返傭比例</font>
				</span></b><b><span
					style="mso-spacerun:'yes';font-family:宋体;letter-spacing:0.0000pt;font-weight:bold;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;mso-shading:rgb(255,255,255);">
					<o:p></o:p>
				</span></b>
		</p>
		<p class=MsoNormal style="text-autospace:ideograph-numeric;mso-pagination:none;"><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<font face="宋体">客戶發展示意如下</font>&nbsp;<font face="宋体">推薦者</font>
				&#62;&nbsp;一代&nbsp;&#62;&nbsp;二代&nbsp;&#62;&nbsp;三代&#62;&nbsp;四代&nbsp;（往下最多四代）
			</span><span
				style="mso-spacerun:'yes';font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal style="text-autospace:ideograph-numeric;mso-pagination:none;"><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<font face="宋体">推薦者可獲得一代</font>5%入金返傭
			</span><span style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal style="text-autospace:ideograph-numeric;mso-pagination:none;"><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<font face="宋体">推薦者可獲得二代</font>3%入金返傭
			</span><span style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal style="text-autospace:ideograph-numeric;mso-pagination:none;"><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<font face="宋体">推薦者可獲得三代</font>2%入金返傭
			</span><span style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal style="text-autospace:ideograph-numeric;mso-pagination:none;"><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<font face="宋体">推薦者可獲得四代</font>1%入金返傭
			</span><span style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal
			style="margin-left:0.0000pt;mso-para-margin-left:0.0000gd;text-indent:0.0000pt;mso-char-indent-count:0.0000;text-autospace:ideograph-numeric;mso-pagination:none;mso-list:l0 level1 lfo1;">
			<![if !supportLists]><span
				style="font-family:宋体;font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;"><span
					style='mso-list:Ignore;'>二、</span></span>
			<![endif]><b><span
					style="mso-spacerun:'yes';font-family:宋体;font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
					<font face="宋体">返傭機制</font>
				</span><span
					style="mso-spacerun:'yes';font-family:宋体;font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
					<o:p></o:p>
				</span></b>
		</p>
		<p class=MsoNormal style="text-autospace:ideograph-numeric;mso-pagination:none;mso-list:l1 level1 lfo2;;font-size:10.5000pt;">
			1.邀請人需通過專屬邀請碼或邀請鏈接邀請好友在GEX平臺註冊，確認帳戶邀請返傭關係
		</p>
		<p class=MsoNormal style="text-autospace:ideograph-numeric;mso-pagination:none;mso-list:l1 level1 lfo2;;font-size:10.5000pt;">
			受邀用戶使用邀請碼或邀請鏈接 完成註冊後 每完成一筆入金會產生對應比例返傭
		</p>
		<p class=MsoNormal style="text-autospace:ideograph-numeric;mso-pagination:none;mso-list:l1 level1 lfo2;">
			<![if !supportLists]><span style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;"><span
					style='mso-list:Ignore;'>3.<span>&nbsp;</span></span></span>
			<![endif]><span style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<font face="宋体">返傭獎勵會以</font>USDT形式發放至您的幣幣帳戶。
			</span><span
				style="mso-spacerun:'yes';font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span>
		</p>
		<p class=MsoNormal style="text-autospace:ideograph-numeric;mso-pagination:none;mso-list:l1 level1 lfo2;">
			<![if !supportLists]><span style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;"><span
					style='mso-list:Ignore;'>4.<span>&nbsp;</span></span></span>
			<![endif]><span style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<font face="宋体">好友返傭採取當日統計，次日入賬；返傭金額</font>=實際入金量*返傭比例
			</span><span
				style="mso-spacerun:'yes';font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span>
		</p>
		<p class=MsoNormal style="text-autospace:ideograph-numeric;mso-pagination:none;mso-list:l1 level1 lfo2;">
			<![if !supportLists]><span style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;"><span
					style='mso-list:Ignore;'>5.<span>&nbsp;</span></span></span>
			<![endif]><span style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<font face="宋体">推薦人享有好友入金返傭的有效期以受推薦人實際註冊時間開始計算，有效期滿後，您將不會收到該推薦人的入金返傭，推薦者可以通過提高</font>
				VIP等級來延長您的返傭時長以及返傭比例
			</span><span
				style="mso-spacerun:'yes';font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span>
		</p>
		<p class=MsoNormal style="text-autospace:ideograph-numeric;mso-pagination:none;mso-list:l1 level1 lfo2;">
			<![if !supportLists]><span style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;"><span
					style='mso-list:Ignore;'>6.<span>&nbsp;</span></span></span>
			<![endif]><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">VIP示意圖</span><span
				style="mso-spacerun:'yes';font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span>
		</p>
		<table class=MsoNormalTable border=0 cellspacing=0
			style="border-collapse:collapse;width:361.5000pt;margin-left:4.6500pt;border:none;mso-padding-alt:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;">
			<tr style="height:36.0000pt;">
				<td width=65 valign=center nowrap
					style="width:65.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:1.0000pt solid rgb(0,0,0);mso-border-left-alt:0.5000pt solid rgb(0,0,0);border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:1.0000pt solid rgb(0,0,0);mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">VIP等級</span><span
							style="font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=116 valign=center nowrap
					style="width:116.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:1.0000pt solid rgb(0,0,0);mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">升級條件</span><span
							style="font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=96 valign=center nowrap
					style="width:96.7500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:1.0000pt solid rgb(0,0,0);mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">時長屬性</span><span
							style="font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=83 valign=center nowrap
					style="width:83.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:1.0000pt solid rgb(0,0,0);mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">返傭屬性</span><span
							style="font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
			</tr>
			<tr style="height:57.0000pt;">
				<td width=65 valign=center nowrap
					style="width:65.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:1.0000pt solid rgb(0,0,0);mso-border-left-alt:0.5000pt solid rgb(0,0,0);border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">VIP1</span><span
							style="font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=116 valign=center nowrap
					style="width:116.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">受推薦者入金一次</span><span
							style="font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=96 valign=center
					style="width:96.7500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">一代返傭</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">60</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;天&nbsp;&nbsp;&nbsp;二代返傭</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">90</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;天&nbsp;&nbsp;三代返傭1</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">20</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;天&nbsp;&nbsp;四代返傭</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">150</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;天</span><span
							style="font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=83 valign=center
					style="width:83.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">一代返傭5%&nbsp;&nbsp;&nbsp;二代返傭3%&nbsp;&nbsp;三代返傭2%&nbsp;&nbsp;&nbsp;四代返傭1%</span><span
							style="font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
			</tr>
			<tr style="height:54.0000pt;">
				<td width=65 valign=center
					style="width:65.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:1.0000pt solid rgb(0,0,0);mso-border-left-alt:0.5000pt solid rgb(0,0,0);border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">VIP2</span><span
							style="font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=116 valign=center
					style="width:116.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">傘下8個VIP1用戶</span><span
							style="font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=96 valign=center
					style="width:96.7500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">一代返傭</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">90</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;天&nbsp;&nbsp;二代返傭</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">120</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;天&nbsp;&nbsp;三代返傭</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">150</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;天&nbsp;&nbsp;四代返傭</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">180</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;天</span><span
							style="font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=83 valign=center
					style="width:83.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">一代返傭6%&nbsp;&nbsp;&nbsp;二代返傭4%&nbsp;&nbsp;三代返傭3%&nbsp;&nbsp;&nbsp;四代返傭2%</span><span
							style="font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
			</tr>
			<tr style="height:54.0000pt;">
				<td width=65 valign=center
					style="width:65.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:1.0000pt solid rgb(0,0,0);mso-border-left-alt:0.5000pt solid rgb(0,0,0);border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">VIP3</span><span
							style="font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=116 valign=center
					style="width:116.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">傘下4個VIP2用戶</span><span
							style="font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=96 valign=center
					style="width:96.7500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">一代返傭</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">120</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;天&nbsp;&nbsp;二代返傭</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">150</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;天&nbsp;&nbsp;三代返傭</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">180</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;天&nbsp;&nbsp;四代返傭</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">210</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;天</span><span
							style="font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=83 valign=center
					style="width:83.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">一代返傭7%&nbsp;&nbsp;&nbsp;二代返傭5%&nbsp;&nbsp;三代返傭4%&nbsp;&nbsp;&nbsp;四代返傭3%</span><span
							style="font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
			</tr>
			<tr style="height:54.0000pt;">
				<td width=65 valign=center
					style="width:65.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:1.0000pt solid rgb(0,0,0);mso-border-left-alt:0.5000pt solid rgb(0,0,0);border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">VIP4</span><span
							style="font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=116 valign=center
					style="width:116.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">傘下2個VIP3用戶</span><span
							style="font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=96 valign=center
					style="width:96.7500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">一代返傭1</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">50</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;天&nbsp;&nbsp;二代返傭</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">180</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;天&nbsp;&nbsp;三代返傭</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">210</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;天&nbsp;&nbsp;四代返傭2</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">40</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;天</span><span
							style="font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=83 valign=center
					style="width:83.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">一代返傭8%&nbsp;&nbsp;&nbsp;二代返傭6%&nbsp;&nbsp;三代返傭5%&nbsp;&nbsp;&nbsp;四代返傭4%</span><span
							style="font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
			</tr>
			<tr style="height:54.0000pt;">
				<td width=65 valign=center
					style="width:65.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:1.0000pt solid rgb(0,0,0);mso-border-left-alt:0.5000pt solid rgb(0,0,0);border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">VIP5</span><span
							style="font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=116 valign=center
					style="width:116.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">傘下1個VIP4用戶</span><span
							style="font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=96 valign=center
					style="width:96.7500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;永久</span><span
							style="font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=83 valign=center
					style="width:83.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">一代返傭10%&nbsp;&nbsp;&nbsp;二代返傭8%&nbsp;&nbsp;三代返傭6%&nbsp;&nbsp;&nbsp;四代返傭5%</span><span
							style="font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
			</tr>
		</table>
		<p class=MsoNormal align=justify
			style="text-autospace:ideograph-numeric;mso-pagination:none;text-align:justify;text-justify:inter-ideograph;">
			<span
				style="mso-spacerun:'yes';font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;mso-shading:rgb(255,255,255);">
				<o:p>&nbsp;</o:p>
			</span></p>
		<p class=MsoNormal
			style="margin-left:0.0000pt;mso-para-margin-left:0.0000gd;text-indent:0.0000pt;mso-char-indent-count:0.0000;text-autospace:ideograph-numeric;mso-pagination:none;mso-list:l0 level1 lfo1;">
			<![if !supportLists]><span
				style="font-family:宋体;font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;"><span
					style='mso-list:Ignore;'>三、</span></span>
			<![endif]><b><span
					style="mso-spacerun:'yes';font-family:宋体;font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
					<font face="宋体">特別說明</font>
				</span></b><b><span
					style="mso-spacerun:'yes';font-family:宋体;font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
					<o:p></o:p>
				</span></b>
		</p>
		<p class=MsoNormal style="text-autospace:ideograph-numeric;mso-pagination:none;"><span
				style="mso-spacerun:'yes';font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;mso-shading:rgb(255,255,255);">
				<font face="宋体">邀請返傭機制可能會根據市場行情即時調整，</font>
			</span><span
				style="mso-spacerun:'yes';font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;mso-shading:rgb(255,255,255);">GEX</span><span
				style="mso-spacerun:'yes';font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;mso-shading:rgb(255,255,255);">
				<font face="宋体">保留對機制的最終解釋權，所有規則變動請以</font>
			</span><span
				style="mso-spacerun:'yes';font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;mso-shading:rgb(255,255,255);">GEX</span><span
				style="mso-spacerun:'yes';font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;mso-shading:rgb(255,255,255);">
				<font face="宋体">官方公告為准。</font>
			</span><span
				style="mso-spacerun:'yes';font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span></p>
	</div>
	<!--EndFragment-->
</body>`,
      en:`<body style="tab-interval:21pt;text-justify-trim:punctuation;">
	<!--StartFragment-->
	<div class="Section0" style="layout-grid:15.6000pt;">
		<p class=MsoNormal align=center style="text-align:center;"><b><span
					style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-weight:bold;font-size:14.0000pt;mso-font-kerning:1.0000pt;">Launch&nbsp;announcement&nbsp;of&nbsp;invitation&nbsp;rebate&nbsp;event&nbsp;</span></b><b><span
					style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-weight:bold;font-size:14.0000pt;mso-font-kerning:1.0000pt;">
					<o:p></o:p>
				</span></b></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">Dear&nbsp;GEX&nbsp;users,</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal style="text-indent:21.0000pt;mso-char-indent-count:2.0000;"><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">GEX&nbsp;will&nbsp;launch&nbsp;a&nbsp;rebate&nbsp;invitation&nbsp;event&nbsp;on&nbsp;June&nbsp;30,&nbsp;2022,&nbsp;which&nbsp;aims&nbsp;to&nbsp;reward&nbsp;loyal&nbsp;GEX&nbsp;users&nbsp;to&nbsp;share&nbsp;the&nbsp;fun&nbsp;of&nbsp;trading&nbsp;on&nbsp;GEX&nbsp;with&nbsp;their&nbsp;friends.&nbsp;As&nbsp;long&nbsp;as&nbsp;the&nbsp;invited&nbsp;user&nbsp;meets&nbsp;the&nbsp;rebate&nbsp;conditions,&nbsp;the&nbsp;inviter&nbsp;will&nbsp;receive&nbsp;a&nbsp;commission&nbsp;reward&nbsp;of&nbsp;up&nbsp;to&nbsp;four&nbsp;generations.</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal style="text-indent:21.0000pt;mso-char-indent-count:2.0000;"><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p>&nbsp;</o:p>
			</span></p>
		<p class=15
			style="margin-left:36.0000pt;text-indent:-36.0000pt;mso-char-indent-count:0.0000;mso-list:l0 level1 lfo1;">
			<![if !supportLists]><span
				style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);"><span
					style='mso-list:Ignore;'>I.<span>&nbsp;</span></span></span>
			<![endif]><b><span
					style="mso-spacerun:'yes';font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">R</span></b><b><span
					style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">ebate&nbsp;proportion</span></b><b><span
					style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
					<o:p></o:p>
				</span></b>
		</p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">Customer&nbsp;development&nbsp;rule&nbsp;is&nbsp;as&nbsp;follows:&nbsp;recommender&nbsp;&#62;&nbsp;First&nbsp;generation&nbsp;&#62;&nbsp;Second&nbsp;Generation&nbsp;&#62;&nbsp;Third&nbsp;Generation&nbsp;&#62;&nbsp;Fourth&nbsp;Generation&nbsp;(up&nbsp;to&nbsp;four&nbsp;generations&nbsp;down)</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">R</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">ecommenders</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">&nbsp;can&nbsp;get&nbsp;a&nbsp;5%&nbsp;rebate&nbsp;for&nbsp;the&nbsp;first&nbsp;generation.</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">R</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">ecommenders</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">&nbsp;can&nbsp;get&nbsp;a&nbsp;3%&nbsp;rebate&nbsp;for&nbsp;the&nbsp;second&nbsp;generation.</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">R</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">ecommenders</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">&nbsp;can&nbsp;get&nbsp;a&nbsp;2%&nbsp;rebate&nbsp;for&nbsp;the&nbsp;third&nbsp;generation.</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">R</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">ecommenders</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">&nbsp;can&nbsp;get&nbsp;a&nbsp;1%&nbsp;rebate&nbsp;for&nbsp;the&nbsp;fourth&nbsp;generation.</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p>&nbsp;</o:p>
			</span></p>
		<p class=15
			style="margin-left:36.0000pt;text-indent:-36.0000pt;mso-char-indent-count:0.0000;mso-list:l0 level1 lfo1;">
			<![if !supportLists]><span
				style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;"><span
					style='mso-list:Ignore;'>II.<span>&nbsp;</span></span></span>
			<![endif]><b><span
					style="mso-spacerun:'yes';font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;">R</span></b><b><span
					style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;">ebate&nbsp;mechanism</span></b><b><span
					style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
					<o:p></o:p>
				</span></b>
		</p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:1.0000pt;">1</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">.&nbsp;The&nbsp;inviter&nbsp;should&nbsp;use&nbsp;the&nbsp;exclusive&nbsp;invitation&nbsp;code&nbsp;or&nbsp;invitation&nbsp;link&nbsp;to&nbsp;invite&nbsp;friends&nbsp;to&nbsp;register&nbsp;on&nbsp;the&nbsp;GEX&nbsp;platform&nbsp;and&nbsp;confirm&nbsp;the&nbsp;account&nbsp;invitation&nbsp;rebate&nbsp;relationship.</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:1.0000pt;">2</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">.&nbsp;A&nbsp;corresponding&nbsp;percentage&nbsp;rebate&nbsp;will&nbsp;be&nbsp;generated&nbsp;for&nbsp;each&nbsp;deposit&nbsp;of&nbsp;the&nbsp;invited&nbsp;users&nbsp;after&nbsp;the&nbsp;invited&nbsp;users&nbsp;complete&nbsp;registration&nbsp;by&nbsp;using&nbsp;an&nbsp;invitation&nbsp;code&nbsp;or&nbsp;an&nbsp;invitation&nbsp;link.</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:1.0000pt;">3</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">.&nbsp;The&nbsp;rebate&nbsp;reward&nbsp;will&nbsp;be&nbsp;paid&nbsp;to&nbsp;your&nbsp;currency&nbsp;account&nbsp;in&nbsp;the&nbsp;form&nbsp;of&nbsp;USDT.</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:1.0000pt;">4</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">.&nbsp;Friends'&nbsp;rebates&nbsp;are&nbsp;counted&nbsp;on&nbsp;the&nbsp;same&nbsp;day&nbsp;and&nbsp;recorded&nbsp;the&nbsp;next&nbsp;day;&nbsp;rebate&nbsp;amount&nbsp;=&nbsp;actual&nbsp;amount&nbsp;of&nbsp;deposit&nbsp;*&nbsp;proportion&nbsp;of&nbsp;rebates</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:1.0000pt;">5</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">.&nbsp;The&nbsp;period&nbsp;of&nbsp;validity&nbsp;of&nbsp;sharing&nbsp;rebates&nbsp;from&nbsp;the&nbsp;friends&#8217;&nbsp;deposit&nbsp;by&nbsp;the&nbsp;recommenders&nbsp;is&nbsp;calculated&nbsp;from&nbsp;the&nbsp;actual&nbsp;registration&nbsp;time&nbsp;of&nbsp;the&nbsp;people&nbsp;being&nbsp;recommended.&nbsp;After&nbsp;the&nbsp;expiration&nbsp;of&nbsp;the&nbsp;period&nbsp;of&nbsp;validity,&nbsp;the&nbsp;recommender&nbsp;will&nbsp;not&nbsp;receive&nbsp;the&nbsp;rebate&nbsp;of&nbsp;the&nbsp;deposit.&nbsp;The&nbsp;recommender&nbsp;can&nbsp;extend&nbsp;the&nbsp;rebate&nbsp;duration&nbsp;and&nbsp;proportion&nbsp;by&nbsp;raising&nbsp;the&nbsp;VIP&nbsp;level.</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">6</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">.VIP&nbsp;diagram</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span></p>
		<table class=MsoNormalTable border=0 cellspacing=0
			style="border-collapse:collapse;width:361.5000pt;margin-left:4.6500pt;border:none;mso-padding-alt:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;">
			<tr style="height:36.0000pt;">
				<td width=65 valign=center nowrap
					style="width:65.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:1.0000pt solid rgb(0,0,0);mso-border-left-alt:0.5000pt solid rgb(0,0,0);border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:1.0000pt solid rgb(0,0,0);mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:1.0000pt;">V</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">IP&nbsp;level</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=116 valign=center nowrap
					style="width:116.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:1.0000pt solid rgb(0,0,0);mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:1.0000pt;">U</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">pgrading&nbsp;conditions</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=96 valign=center nowrap
					style="width:96.7500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:1.0000pt solid rgb(0,0,0);mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:1.0000pt;">D</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">uration&nbsp;attribute</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=83 valign=center nowrap
					style="width:83.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:1.0000pt solid rgb(0,0,0);mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:1.0000pt;">R</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">ebate&nbsp;attribute</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
			</tr>
			<tr style="height:57.0000pt;">
				<td width=65 valign=center nowrap
					style="width:65.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:1.0000pt solid rgb(0,0,0);mso-border-left-alt:0.5000pt solid rgb(0,0,0);border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">VIP1</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=116 valign=center nowrap
					style="width:116.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:1.0000pt;">T</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">he&nbsp;people&nbsp;being&nbsp;recommended&nbsp;deposit&nbsp;for&nbsp;once</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=96 valign=center
					style="width:96.7500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=justify
						style="margin-left:10.5000pt;mso-para-margin-left:1.0000gd;text-indent:5.2500pt;mso-char-indent-count:0.5000;mso-pagination:widow-orphan;text-align:justify;text-justify:inter-ideograph;vertical-align:middle;">
						<span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:0.0000pt;">F</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">irst-generation&nbsp;rebate&nbsp;-&nbsp;60&nbsp;days</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:0.0000pt;">S</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">econd-generation&nbsp;rebate-90&nbsp;days</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">Third-generation&nbsp;rebate&nbsp;-120&nbsp;days</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:1.0000pt;">F</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">ourth-generation&nbsp;rebate-150&nbsp;days</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=83 valign=center
					style="width:83.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:0.0000pt;">F</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">irst-generation&nbsp;rebate&nbsp;5%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;&nbsp;</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:0.0000pt;">S</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">econd-generation&nbsp;rebate&nbsp;3%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">Third-generation&nbsp;rebate&nbsp;2%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:1.0000pt;">F</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">ourth-generation&nbsp;rebate&nbsp;1%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
			</tr>
			<tr style="height:54.0000pt;">
				<td width=65 valign=center
					style="width:65.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:1.0000pt solid rgb(0,0,0);mso-border-left-alt:0.5000pt solid rgb(0,0,0);border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">VIP2</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=116 valign=center
					style="width:116.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:1.0000pt;">T</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">he&nbsp;subordinate&nbsp;8&nbsp;VIP&nbsp;1&nbsp;users&nbsp;</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=96 valign=center
					style="width:96.7500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:0.0000pt;">F</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">irst-generation&nbsp;rebate&nbsp;&#8211;&nbsp;90&nbsp;days</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:0.0000pt;">S</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">econd-generation&nbsp;rebate-120&nbsp;days</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">Third-generation&nbsp;rebate&nbsp;-150&nbsp;days</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:1.0000pt;">F</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">ourth-generation&nbsp;rebate-180&nbsp;days</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=83 valign=center
					style="width:83.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:0.0000pt;">F</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">irst-generation&nbsp;rebate&nbsp;6%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;</span><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:0.0000pt;">S</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">econd-generation&nbsp;rebate&nbsp;4%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">Third-generation&nbsp;rebate&nbsp;3%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:1.0000pt;">F</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">ourth-generation&nbsp;rebate&nbsp;2%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
			</tr>
			<tr style="height:54.0000pt;">
				<td width=65 valign=center
					style="width:65.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:1.0000pt solid rgb(0,0,0);mso-border-left-alt:0.5000pt solid rgb(0,0,0);border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">VIP3</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=116 valign=center
					style="width:116.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:1.0000pt;">T</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">he&nbsp;subordinate&nbsp;4&nbsp;VIP&nbsp;2&nbsp;users</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=96 valign=center
					style="width:96.7500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=justify
						style="mso-pagination:widow-orphan;text-align:justify;text-justify:inter-ideograph;vertical-align:middle;">
						<span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:0.0000pt;">F</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">irst-generation&nbsp;rebate&nbsp;&#8211;&nbsp;120&nbsp;days</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:0.0000pt;">S</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">econd-generation&nbsp;rebate-150&nbsp;days</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">Third-generation&nbsp;rebate&nbsp;-180&nbsp;days</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:1.0000pt;">F</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">ourth-generation&nbsp;rebate-210&nbsp;days</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=83 valign=center
					style="width:83.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:0.0000pt;">F</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">irst-generation&nbsp;rebate&nbsp;7%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:0.0000pt;">S</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">econd-generation&nbsp;rebate&nbsp;5%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">Third-generation&nbsp;rebate&nbsp;4%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:1.0000pt;">F</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">ourth-generation&nbsp;rebate&nbsp;3%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
			</tr>
			<tr style="height:54.0000pt;">
				<td width=65 valign=center
					style="width:65.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:1.0000pt solid rgb(0,0,0);mso-border-left-alt:0.5000pt solid rgb(0,0,0);border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">VIP4</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=116 valign=center
					style="width:116.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p>&nbsp;</o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:1.0000pt;">T</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">he&nbsp;subordinate&nbsp;2&nbsp;VIP&nbsp;3&nbsp;users</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=96 valign=center
					style="width:96.7500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p>&nbsp;</o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:0.0000pt;">F</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">irst-generation&nbsp;rebate&nbsp;&#8211;&nbsp;150&nbsp;days</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:0.0000pt;">S</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">econd-generation&nbsp;rebate-180&nbsp;days</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">Third-generation&nbsp;rebate&nbsp;-210&nbsp;days</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=justify
						style="mso-pagination:widow-orphan;text-align:justify;text-justify:inter-ideograph;vertical-align:middle;">
						<span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p>&nbsp;</o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:1.0000pt;">F</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">ourth-generation&nbsp;rebate-240&nbsp;days</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=83 valign=center
					style="width:83.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=justify
						style="mso-pagination:widow-orphan;text-align:justify;text-justify:inter-ideograph;vertical-align:middle;">
						<span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:0.0000pt;">F</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">irst-generation&nbsp;rebate&nbsp;8%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;&nbsp;</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:0.0000pt;">S</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">econd-generation&nbsp;rebate&nbsp;6%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">Third-generation&nbsp;rebate&nbsp;5%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;&nbsp;</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:1.0000pt;">F</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">ourth-generation&nbsp;rebate&nbsp;4%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
			</tr>
			<tr style="height:54.0000pt;">
				<td width=65 valign=center
					style="width:65.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:1.0000pt solid rgb(0,0,0);mso-border-left-alt:0.5000pt solid rgb(0,0,0);border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">VIP5</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=116 valign=center
					style="width:116.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:1.0000pt;">T</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">he&nbsp;subordinate&nbsp;1&nbsp;VIP4&nbsp;user</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=96 valign=center
					style="width:96.7500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:1.0000pt;">P</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">ermanent</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=83 valign=center
					style="width:83.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p>&nbsp;</o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:0.0000pt;">F</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">irst-generation&nbsp;rebate&nbsp;10%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:0.0000pt;">S</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">econd-generation&nbsp;rebate&nbsp;8%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">Third-generation&nbsp;rebate&nbsp;6%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-size:10.5000pt;mso-font-kerning:1.0000pt;">F</span><span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">ourth-generation&nbsp;rebate&nbsp;5%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
			</tr>
		</table>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p>&nbsp;</o:p>
			</span></p>
		<p class=15
			style="margin-left:36.0000pt;text-indent:-36.0000pt;mso-char-indent-count:0.0000;mso-list:l0 level1 lfo1;">
			<![if !supportLists]><span
				style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;"><span
					style='mso-list:Ignore;'>III.<span>&nbsp;</span></span></span>
			<![endif]><b><span
					style="mso-spacerun:'yes';font-family:宋体;mso-ascii-font-family:'Times New Roman';mso-hansi-font-family:'Times New Roman';mso-bidi-font-family:'Times New Roman';font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;">S</span></b><b><span
					style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;">pecial&nbsp;notes</span></b><b><span
					style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
					<o:p></o:p>
				</span></b>
		</p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">The&nbsp;invitation&nbsp;rebate&nbsp;mechanism&nbsp;may&nbsp;be&nbsp;adjusted&nbsp;in&nbsp;real&nbsp;time&nbsp;according&nbsp;to&nbsp;the&nbsp;market&nbsp;situation.&nbsp;GEX&nbsp;reserves&nbsp;the&nbsp;right&nbsp;of&nbsp;final&nbsp;interpretation&nbsp;of&nbsp;the&nbsp;mechanism.&nbsp;For&nbsp;all&nbsp;rule&nbsp;changes,&nbsp;please&nbsp;refer&nbsp;to&nbsp;the&nbsp;official&nbsp;announcement&nbsp;of&nbsp;GEX.</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span></p>
	</div>
	<!--EndFragment-->
</body>`,
    jp:`<body style="tab-interval:21pt;text-justify-trim:punctuation;">
	<!--StartFragment-->
	<div class="Section0" style="layout-grid:15.6000pt;">
		<p class=MsoNormal align=center style="text-align:center;"><b><span
					style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-weight:bold;font-size:14.0000pt;mso-font-kerning:1.0000pt;">
					<font face="MS Mincho">招待リベートイベント開始のお知らせ</font>
				</span></b><b><span
					style="mso-spacerun:'yes';font-family:宋体;mso-fareast-font-family:'MS Mincho';font-weight:bold;font-size:14.0000pt;mso-font-kerning:1.0000pt;">
					<o:p></o:p>
				</span></b></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">GEX
				<font face="MS Mincho">ユーザーの皆様へ</font></span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal style="text-indent:21.0000pt;mso-char-indent-count:2.0000;"><span
				style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">GEX
				<font face="MS Mincho">は、</font>
				<font face="宋体">2022</font>
				<font face="MS Mincho">年</font>
				<font face="宋体">6</font>
				<font face="MS Mincho">月</font>
				<font face="宋体">30</font>
				<font face="MS Mincho">日に招待リベートイベントを開始します。招待リベートイベントは、</font>
				<font face="宋体">GEX</font>
				<font face="MS Mincho">の忠実なユーザーとその友人に、</font>
				<font face="宋体">GEX</font>
				<font face="MS Mincho">での取引の楽しさを共有するように報いることを目的としています。&nbsp;招待されたユーザーがコミッションのリベート条件を満たしていれば、招待者は最大
				</font>
				<font face="宋体">4</font>
				<font face="MS Mincho">世代のコミッション報酬を受け取ることができます</font>
			</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal><b><span
					style="mso-spacerun:'yes';font-family:宋体;font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">1.リベート比率</span></b><b><span
					style="mso-spacerun:'yes';font-family:宋体;font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
					<o:p></o:p>
				</span></b></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<font face="宋体">客戶發展示意如下</font>&nbsp;<font face="宋体">推薦者</font>
				&#62;&nbsp;一代&nbsp;&#62;&nbsp;二代&nbsp;&#62;&nbsp;三代&#62;&nbsp;四代&nbsp;（往下最多四代）
			</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<font face="MS Mincho">顧客開拓は次のように示されます：推薦者</font>&#62;<font face="MS Mincho">第</font>
				<font face="宋体">1</font>
				<font face="MS Mincho">世代</font>
				<font face="宋体">&#62;</font>
				<font face="MS Mincho">第</font>
				<font face="宋体">2</font>
				<font face="MS Mincho">世代</font>
				<font face="宋体">&#62;</font>
				<font face="MS Mincho">第</font>
				<font face="宋体">3</font>
				<font face="MS Mincho">世代</font>
				<font face="宋体">&#62;</font>
				<font face="MS Mincho">第</font>
				<font face="宋体">4</font>
				<font face="MS Mincho">世代（下まで最大</font>
				<font face="宋体">4</font>
				<font face="MS Mincho">世代）</font>
			</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<font face="MS Mincho">推薦者は第１世代</font>5<font face="MS Mincho">％のデポジットリベートを受け取ることができます</font>
			</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<font face="MS Mincho">推薦者は第２世代</font>3<font face="MS Mincho">％のデポジットリベートを受け取ることができます</font>
			</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<font face="MS Mincho">推薦者は第</font>3<font face="MS Mincho">世代</font>
				<font face="宋体">2</font>
				<font face="MS Mincho">％のデポジットリベートを受け取ることができます</font>
			</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<font face="MS Mincho">推薦者は第</font>4<font face="MS Mincho">世代</font>
				<font face="宋体">1</font>
				<font face="MS Mincho">％のデポジットリベートを受け取ることができます</font>
			</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal><b><span
					style="mso-spacerun:'yes';font-family:宋体;font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;">2.リベートメカニズム</span></b><b><span
					style="mso-spacerun:'yes';font-family:宋体;font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
					<o:p></o:p>
				</span></b></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">1.招待者は、専用招待コードまたは招待リンクを通してGEXプラットフォームに登録するように友人を招待し、アカウントの招待リベート関係を確定します。</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">2.招待ユーザーが招待コードまたは招待リンクを使って登録を完了すれば、毎回デポジットが完了するたびに相応なリベートが生成されます。</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">3.手数料の報酬は、USDTの形式で通貨口座まで振り込まれます。</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">4.友人のリベートは、当日計算され、翌日に記帳されます。リベート金額=実際のデポジット金額*リベート比率</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">5.推薦者の友人のデポジットリベートの有効期間は、推薦者の実際の登録時間から計算されます。有効期間が終了すると、該当推薦者のデポジットリベートは受け取られなくなります。推薦者は、VIPレベルアップすることでデポジットリベート有効期限とリベート比率を延長することができます。</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">6.</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">&nbsp;VIPの見取り図</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span></p>
		<table class=MsoNormalTable border=0 cellspacing=0
			style="border-collapse:collapse;width:361.5000pt;margin-left:4.6500pt;border:none;mso-padding-alt:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;">
			<tr style="height:36.0000pt;">
				<td width=65 valign=center nowrap
					style="width:65.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:1.0000pt solid rgb(0,0,0);mso-border-left-alt:0.5000pt solid rgb(0,0,0);border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:1.0000pt solid rgb(0,0,0);mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">VIPレベル</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=116 valign=center nowrap
					style="width:116.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:1.0000pt solid rgb(0,0,0);mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">レベルアップ条件</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=96 valign=center nowrap
					style="width:96.7500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:1.0000pt solid rgb(0,0,0);mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:1.0000pt;">期限属性</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=83 valign=center nowrap
					style="width:83.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:1.0000pt solid rgb(0,0,0);mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">リベート属性</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
			</tr>
			<tr style="height:57.0000pt;">
				<td width=65 valign=center nowrap
					style="width:65.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:1.0000pt solid rgb(0,0,0);mso-border-left-alt:0.5000pt solid rgb(0,0,0);border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">VIP1</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=116 valign=center nowrap
					style="width:116.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">紹介金
							<font face="宋体">1</font>
							<font face="MS Mincho">回</font>
						</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=96 valign=center
					style="width:96.7500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p>&nbsp;</o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第１世代リベート
							<font face="宋体">60</font>
							<font face="MS Mincho">日間</font>
						</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;&nbsp;</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第２世代リベート
							<font face="宋体">90</font>
							<font face="MS Mincho">日間</font>
						</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第
							<font face="宋体">3</font>
							<font face="MS Mincho">世代リベート</font>
							<font face="宋体">120</font>
							<font face="MS Mincho">日間</font>
						</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第
							<font face="宋体">4</font>
							<font face="MS Mincho">世代リベート</font>
							<font face="宋体">150</font>
							<font face="MS Mincho">日間</font>
						</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=83 valign=center
					style="width:83.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=justify
						style="mso-pagination:widow-orphan;text-align:justify;text-justify:inter-ideograph;vertical-align:middle;">
						<span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p>&nbsp;</o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第１世代リベート
							<font face="宋体">5</font>
							<font face="MS Mincho">％</font>
						</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;&nbsp;</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第
							<font face="宋体">2</font>
							<font face="MS Mincho">世代リベート</font>
							<font face="宋体">3</font>
							<font face="MS Mincho">％</font>
						</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第
							<font face="宋体">3</font>
							<font face="MS Mincho">世代リベート</font>
							<font face="宋体">2</font>
							<font face="MS Mincho">％</font>
						</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;&nbsp;</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第
							<font face="宋体">4</font>
							<font face="MS Mincho">世代リベート１％</font>
						</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
			</tr>
			<tr style="height:54.0000pt;">
				<td width=65 valign=center
					style="width:65.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:1.0000pt solid rgb(0,0,0);mso-border-left-alt:0.5000pt solid rgb(0,0,0);border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">VIP2</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=116 valign=center
					style="width:116.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p>&nbsp;</o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">傘下に
							<font face="宋体">8</font>
							<font face="MS Mincho">人の</font>
							<font face="宋体">VIP1</font>
							<font face="MS Mincho">ユーザーがいる</font>
						</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=96 valign=center
					style="width:96.7500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第１世代リベート
							<font face="宋体">90</font>
							<font face="MS Mincho">日間</font>
						</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第
							<font face="宋体">2</font>
							<font face="MS Mincho">世代リベート</font>
							<font face="宋体">120</font>
							<font face="MS Mincho">日間</font>
						</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">3</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">世代リベート</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">150</span><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">日間</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">4</span><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">世代リベート</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">180&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">日間</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=83 valign=center
					style="width:83.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第１世代リベート</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">6</span><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">％</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">2</span><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">世代リベート</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">4</span><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">％</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">3</span><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">世代リベート</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">3</span><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">％</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">4</span><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">世代リベート</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">2</span><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">％</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
			</tr>
			<tr style="height:54.0000pt;">
				<td width=65 valign=center
					style="width:65.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:1.0000pt solid rgb(0,0,0);mso-border-left-alt:0.5000pt solid rgb(0,0,0);border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">VIP3</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=116 valign=center
					style="width:116.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">傘下に
							<font face="宋体">4</font>
							<font face="MS Mincho">人の</font>
							<font face="宋体">VIP2</font>
							<font face="MS Mincho">ユーザーがいる</font>
						</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=96 valign=center
					style="width:96.7500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p>&nbsp;</o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第１世代リベート</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">12</span><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">0
							<font face="MS Mincho">日間</font></span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">2</span><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">世代リベート</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">150</span><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">日間</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">3</span><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">世代リベート</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">180</span><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">日間</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">4</span><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">世代リベート</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">210</span><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">日間</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=83 valign=center
					style="width:83.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p>&nbsp;</o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第１世代リベート</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">7</span><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">％</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">2</span><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">世代リベート
							<font face="宋体">5</font>
							<font face="MS Mincho">％</font>
						</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">3</span><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">世代リベート</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">4</span><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">％</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;&nbsp;</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">4</span><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">世代リベート</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">3</span><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">％</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p>&nbsp;</o:p>
						</span></p>
				</td>
			</tr>
			<tr style="height:54.0000pt;">
				<td width=65 valign=center
					style="width:65.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:1.0000pt solid rgb(0,0,0);mso-border-left-alt:0.5000pt solid rgb(0,0,0);border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">VIP4</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=116 valign=center
					style="width:116.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p>&nbsp;</o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">傘下に
							<font face="宋体">2</font>
							<font face="MS Mincho">人の</font>
							<font face="宋体">VIP3</font>
							<font face="MS Mincho">ユーザーがいる</font>
						</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=96 valign=center
					style="width:96.7500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第１世代リベート</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">150</span><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">日間</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">2</span><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">世代リベート</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">18</span><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">0
							<font face="MS Mincho">日間</font></span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">3</span><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">世代リベート</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">21</span><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">0
							<font face="MS Mincho">日間</font></span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">4</span><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">世代リベート</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">24</span><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">0
							<font face="MS Mincho">日間</font></span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=83 valign=center
					style="width:83.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=justify
						style="mso-pagination:widow-orphan;text-align:justify;text-justify:inter-ideograph;vertical-align:middle;">
						<span style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第１世代リベート</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">8</span><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">％</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">2</span><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">世代リベート</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">6</span><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">％</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p>&nbsp;</o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">3</span><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">世代リベート</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">5</span><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">％</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p>&nbsp;</o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">4</span><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">世代リベート</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">4</span><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">％</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
			</tr>
			<tr style="height:54.0000pt;">
				<td width=65 valign=center
					style="width:65.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:1.0000pt solid rgb(0,0,0);mso-border-left-alt:0.5000pt solid rgb(0,0,0);border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">VIP5</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=116 valign=center
					style="width:116.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p>&nbsp;</o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">傘下に１人の
							<font face="宋体">VIP4</font>
							<font face="MS Mincho">ユーザーがいる</font>
						</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=96 valign=center
					style="width:96.7500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">永久</span><span
							style="font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=83 valign=center
					style="width:83.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第１世代リベート</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">10</span><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">％</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">2</span><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">世代リベート</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">8</span><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">％</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;&nbsp;</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">3</span><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">世代リベート</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">6</span><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">％</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">第</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">4</span><span
							style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">世代リベート</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">5</span><span
							style="font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">％</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
			</tr>
		</table>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p>&nbsp;</o:p>
			</span></p>
		<p class=MsoNormal><b><span
					style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;">3.
					<font face="MS Mincho">特別説明</font></span></b><b><span
					style="mso-spacerun:'yes';font-family:宋体;font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
					<o:p></o:p>
				</span></b></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:'MS Mincho';mso-ascii-font-family:宋体;mso-hansi-font-family:宋体;mso-bidi-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<font face="MS Mincho">招待状のリベートメカニズムは、市況に応じてリアルタイムで調整される場合があります。</font>GEX<font face="MS Mincho">
					は、メカニズムの最終的な解釈の権利を留保します。すべてのルールの変更については、</font>
				<font face="宋体">GEX</font>
				<font face="MS Mincho">の公式発表を参照してください。</font>
			</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-fareast-font-family:'MS Mincho';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span></p>
	</div>
	<!--EndFragment-->
</body>`,
      vn:`<body style="tab-interval:21pt;text-justify-trim:punctuation;">
	<!--StartFragment-->
	<div class="Section0" style="layout-grid:15.6000pt;">
		<p class=MsoNormal align=center style="text-autospace:ideograph-numeric;mso-pagination:none;text-align:center;">
			<b><span
					style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-weight:bold;font-size:14.0000pt;mso-font-kerning:1.0000pt;">&nbsp;</span></b><b><span
					style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-weight:bold;font-size:12.0000pt;mso-font-kerning:1.0000pt;">TH&#212;NG&nbsp;B&#193;O&nbsp;HO&#7840;T&nbsp;&#272;&#7896;NG&nbsp;ONLINE&nbsp;CHI&#7870;T&nbsp;KH&#7844;U&nbsp;GI&#7898;I&nbsp;THI&#7878;U</span></b><b><span
					style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-weight:bold;font-size:12.0000pt;mso-font-kerning:1.0000pt;">
					<o:p></o:p>
				</span></b></p>
		<p class=MsoNormal align=center style="text-autospace:ideograph-numeric;mso-pagination:none;text-align:center;">
			<b><span
					style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-weight:bold;font-size:12.0000pt;mso-font-kerning:1.0000pt;">
					<o:p>&nbsp;</o:p>
				</span></b></p>
		<p class=MsoNormal style="text-autospace:ideograph-numeric;mso-pagination:none;"><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">K&#237;nh&nbsp;g&#7917;i&nbsp;ng&#432;&#7901;i&nbsp;d&#249;ng&nbsp;GEX</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal
			style="text-indent:21.0000pt;mso-char-indent-count:2.0000;text-autospace:ideograph-numeric;mso-pagination:none;">
			<span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">GEX&nbsp;s&#7869;&nbsp;kh&#7903;i&nbsp;&#273;&#7897;ng&nbsp;ho&#7841;t&nbsp;&#273;&#7897;ng&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">chi&#7871;t&nbsp;kh&#7845;u</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">gi&#7899;i&nbsp;thi&#7879;u</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">&nbsp;v&#224;o&nbsp;ng&#224;y&nbsp;30&nbsp;th&#225;ng&nbsp;6&nbsp;n&#259;m&nbsp;2022.&nbsp;Ho&#7841;t&nbsp;&#273;&#7897;ng&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">chi&#7871;t&nbsp;kh&#7845;u&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">gi&#7899;i&nbsp;thi&#7879;u</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">&nbsp;nh&#7857;m&nbsp;m&#7909;c&nbsp;&#273;&#237;ch&nbsp;th&#432;&#7903;ng&nbsp;cho&nbsp;nh&#7919;ng&nbsp;ng&#432;&#7901;i&nbsp;d&#249;ng&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">th&#226;n&nbsp;thi&#7871;t</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">&nbsp;c&#7911;a&nbsp;GEX&nbsp;v&#224;&nbsp;b&#7841;n&nbsp;b&#232;&nbsp;c&#7911;a&nbsp;h&#7885;&nbsp;&#273;&#7875;&nbsp;chia&nbsp;s&#7867;&nbsp;ni&#7873;m&nbsp;vui&nbsp;khi&nbsp;giao&nbsp;d&#7883;ch&nbsp;tr&#234;n&nbsp;GEX.&nbsp;Mi&#7877;n&nbsp;l&#224;&nbsp;ng&#432;&#7901;i&nbsp;d&#249;ng&nbsp;&#273;&#432;&#7907;c&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">gi&#7899;i&nbsp;thi&#7879;u&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">&#273;&#225;p&nbsp;&#7913;ng&nbsp;c&#225;c&nbsp;&#273;i&#7873;u&nbsp;ki&#7879;n&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">chi&#7871;t&nbsp;kh&#7845;u</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">,&nbsp;ng&#432;&#7901;i&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">gi&#7899;i&nbsp;thi&#7879;u</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">&nbsp;c&#243;&nbsp;th&#7875;&nbsp;nh&#7853;n&nbsp;&#273;&#432;&#7907;c&nbsp;t&#7889;i&nbsp;&#273;a&nbsp;b&#7889;n&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">c&#7845;p&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">ph&#7847;n&nbsp;th&#432;&#7903;ng&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">chi&#7871;t&nbsp;kh&#7845;u.</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal style="text-autospace:ideograph-numeric;mso-pagination:none;"><b><span
					style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;letter-spacing:0.0000pt;font-weight:bold;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">I.&nbsp;T&#7927;&nbsp;l&#7879;&nbsp;nh&#7853;n&nbsp;chi&#7871;t&nbsp;kh&#7845;u</span></b><b><span
					style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;letter-spacing:0.0000pt;font-weight:bold;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
					<o:p></o:p>
				</span></b></p>
		<p class=MsoNormal style="text-autospace:ideograph-numeric;mso-pagination:none;"><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">S&#7921;&nbsp;ph&#225;t&nbsp;tri&#7875;n&nbsp;c&#7911;a&nbsp;kh&#225;ch&nbsp;h&#224;ng&nbsp;&#273;&#432;&#7907;c&nbsp;th&#7875;&nbsp;hi&#7879;n&nbsp;nh&#432;&nbsp;sau:&nbsp;ng&#432;&#7901;i&nbsp;gi&#7899;i&nbsp;thi&#7879;u&#62;&nbsp;c&#7845;p&nbsp;th&#7913;&nbsp;nh&#7845;t&#62;&nbsp;c&#7845;p&nbsp;th&#7913;&nbsp;hai&#62;&nbsp;c&#7845;p&nbsp;th&#7913;&nbsp;ba&#62;&nbsp;c&#7845;p&nbsp;th&#7913;&nbsp;t&#432;&nbsp;(&nbsp;t&#7889;i&nbsp;&#273;a&nbsp;b&#7889;n&nbsp;c&#7845;p)</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal style="text-autospace:ideograph-numeric;mso-pagination:none;"><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">Ng&#432;&#7901;i&nbsp;gi&#7899;i&nbsp;thi&#7879;u&nbsp;c&#243;&nbsp;th&#7875;&nbsp;nh&#7853;n&nbsp;&#273;&#432;&#7907;c&nbsp;kho&#7843;n&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;5%&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">c&#7911;a&nbsp;c&#7845;p&nbsp;th&#7913;&nbsp;nh&#7845;t</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal style="text-autospace:ideograph-numeric;mso-pagination:none;"><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">Ng&#432;&#7901;i&nbsp;gi&#7899;i&nbsp;thi&#7879;u&nbsp;c&#243;&nbsp;th&#7875;&nbsp;nh&#7853;n&nbsp;&#273;&#432;&#7907;c&nbsp;kho&#7843;n&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;3%&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">c&#7911;a&nbsp;c&#7845;p&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">th&#7913;&nbsp;hai</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal style="text-autospace:ideograph-numeric;mso-pagination:none;"><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">Ng&#432;&#7901;i&nbsp;gi&#7899;i&nbsp;thi&#7879;u&nbsp;c&#243;&nbsp;th&#7875;&nbsp;nh&#7853;n&nbsp;&#273;&#432;&#7907;c&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">kho&#7843;n&nbsp;chi&#7871;t&nbsp;kh&#7845;u</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">&nbsp;2%</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">&nbsp;c&#7911;a&nbsp;c&#7845;p&nbsp;th&#7913;&nbsp;ba</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal style="text-autospace:ideograph-numeric;mso-pagination:none;"><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">Ng&#432;&#7901;i&nbsp;gi&#7899;i&nbsp;thi&#7879;u&nbsp;c&#243;&nbsp;th&#7875;&nbsp;nh&#7853;n&nbsp;&#273;&#432;&#7907;c&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">kho&#7843;n&nbsp;chi&#7871;t&nbsp;kh&#7845;u</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">&nbsp;1%</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">&nbsp;c&#7911;a&nbsp;c&#7845;p&nbsp;th&#7913;&nbsp;t&#432;</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal style="text-autospace:ideograph-numeric;mso-pagination:none;"><b><span
					style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;">II.C&#417;&nbsp;ch&#7871;&nbsp;chi&#7871;t&nbsp;kh&#7845;u</span></b><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal style="text-autospace:ideograph-numeric;mso-pagination:none;"><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">1.&nbsp;Ng&#432;&#7901;i&nbsp;gi&#7899;i&nbsp;thi&#7879;u&nbsp;c&#7847;n&nbsp;m&#7901;i&nbsp;b&#7841;n&nbsp;b&#232;&nbsp;&#273;&#259;ng&nbsp;k&#253;&nbsp;tr&#234;n&nbsp;n&#7873;n&nbsp;t&#7843;ng&nbsp;GEX&nbsp;th&#244;ng&nbsp;qua&nbsp;m&#227;&nbsp;gi&#7899;i&nbsp;thi&#7879;u&nbsp;&#273;&#7897;c&nbsp;quy&#7873;n&nbsp;ho&#7863;c&nbsp;li&#234;n&nbsp;k&#7871;t&nbsp;gi&#7899;i&nbsp;thi&#7879;u&nbsp;v&#224;&nbsp;x&#225;c&nbsp;nh&#7853;n&nbsp;m&#7889;i&nbsp;quan&nbsp;h&#7879;&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;gi&#7899;i&nbsp;thi&#7879;u&nbsp;c&#7911;a&nbsp;t&#224;i&nbsp;kho&#7843;n</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal style="text-autospace:ideograph-numeric;mso-pagination:none;"><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">2.&nbsp;Sau&nbsp;khi&nbsp;ng&#432;&#7901;i&nbsp;d&#249;ng&nbsp;&#273;&#432;&#7907;c&nbsp;m&#7901;i&nbsp;ho&#224;n&nbsp;t&#7845;t&nbsp;&#273;&#259;ng&nbsp;k&#253;&nbsp;b&#7857;ng&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">m&#227;&nbsp;gi&#7899;i&nbsp;thi&#7879;u</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">&nbsp;ho&#7863;c&nbsp;li&#234;n&nbsp;k&#7871;t&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">gi&#7899;i&nbsp;thi&#7879;u</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">,&nbsp;m&#7897;t&nbsp;kho&#7843;n&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">chi&#7871;t&nbsp;kh&#7845;u</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">&nbsp;t&#432;&#417;ng&nbsp;&#7913;ng&nbsp;s&#7869;&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">c&#243;</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">&nbsp;cho&nbsp;m&#7895;i&nbsp;l&#7847;n&nbsp;ho&#224;n&nbsp;th&#224;nh</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">&nbsp;&#273;&#259;ng&nbsp;k&#253;</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">.</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal style="text-autospace:ideograph-numeric;mso-pagination:none;"><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">3.&nbsp;Ph&#7847;n&nbsp;th&#432;&#7903;ng&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;s&#7869;&nbsp;&#273;&#432;&#7907;c&nbsp;c&#7845;p&nbsp;cho&nbsp;t&#224;i&nbsp;kho&#7843;n&nbsp;ti&#7873;n&nbsp;c&#7911;a&nbsp;b&#7841;n&nbsp;d&#432;&#7899;i&nbsp;d&#7841;ng&nbsp;USDT.</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal style="text-autospace:ideograph-numeric;mso-pagination:none;"><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">4.&nbsp;C&#225;c&nbsp;kho&#7843;n&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;c&#7911;a&nbsp;b&#7841;n&nbsp;b&#232;&nbsp;&#273;&#432;&#7907;c&nbsp;t&#237;nh&nbsp;trong&nbsp;c&#249;ng&nbsp;m&#7897;t&nbsp;ng&#224;y&nbsp;v&#224;&nbsp;&#273;&#432;&#7907;c&nbsp;v&#224;o&nbsp;t&#224;i&nbsp;kho&#7843;n&nbsp;v&#224;o&nbsp;ng&#224;y&nbsp;h&#244;m&nbsp;sau;&nbsp;s&#7889;&nbsp;ti&#7873;n&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;=&nbsp;s&#7889;&nbsp;ti&#7873;n&nbsp;n&#7841;p&nbsp;th&#7921;c&nbsp;t&#7871;&nbsp;*&nbsp;t&#7927;&nbsp;l&#7879;&nbsp;chi&#7871;t&nbsp;kh&#7845;u</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal style="text-autospace:ideograph-numeric;mso-pagination:none;"><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">5.&nbsp;Th&#7901;i&nbsp;h&#7841;n&nbsp;hi&#7879;u&nbsp;l&#7921;c&nbsp;c&#7911;a&nbsp;kho&#7843;n&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;ti&#7873;n&nbsp;n&#7841;p&nbsp;c&#7911;a&nbsp;b&#7841;n&nbsp;b&#232;&nbsp;c&#7911;a&nbsp;ng&#432;&#7901;i&nbsp;gi&#7899;i&nbsp;thi&#7879;u&nbsp;&#273;&#432;&#7907;c&nbsp;t&#237;nh&nbsp;t&#7915;&nbsp;th&#7901;i&nbsp;&#273;i&#7875;m&nbsp;&#273;&#259;ng&nbsp;k&#253;&nbsp;th&#7921;c&nbsp;t&#7871;&nbsp;c&#7911;a&nbsp;ng&#432;&#7901;i&nbsp;gi&#7899;i&nbsp;thi&#7879;u,&nbsp;sau&nbsp;khi&nbsp;h&#7871;t&nbsp;th&#7901;i&nbsp;h&#7841;n&nbsp;hi&#7879;u&nbsp;l&#7921;c,&nbsp;b&#7841;n&nbsp;s&#7869;&nbsp;kh&#244;ng&nbsp;nh&#7853;n&nbsp;&#273;&#432;&#7907;c&nbsp;kho&#7843;n&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;ti&#7873;n&nbsp;n&#7841;p&nbsp;c&#7911;a&nbsp;ng&#432;&#7901;i&nbsp;gi&#7899;i&nbsp;thi&#7879;u&nbsp;n&#7919;a.&nbsp;Ng&#432;&#7901;i&nbsp;gi&#7899;i&nbsp;thi&#7879;u&nbsp;c&#243;&nbsp;th&#7875;&nbsp;gia&nbsp;h&#7841;n&nbsp;c&#7845;p&nbsp;&#273;&#7897;&nbsp;VIP&nbsp;&#273;&#7875;&nbsp;k&#233;o&nbsp;d&#224;i&nbsp;th&#7901;i&nbsp;gian&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;c&#7911;a&nbsp;b&#7841;n&nbsp;v&#224;&nbsp;t&#7881;&nbsp;l&#7879;&nbsp;chi&#7871;t&nbsp;kh&#7845;u</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal style="text-autospace:ideograph-numeric;mso-pagination:none;"><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">6.&nbsp;S&#417;&nbsp;&#273;&#7891;&nbsp;VIP</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span></p>
		<table class=MsoNormalTable border=0 cellspacing=0
			style="border-collapse:collapse;width:409.9500pt;margin-left:4.6500pt;mso-table-layout-alt:fixed;border:none;mso-padding-alt:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;">
			<tr style="height:36.0000pt;">
				<td width=65 valign=center nowrap
					style="width:65.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:1.0000pt solid rgb(0,0,0);mso-border-left-alt:0.5000pt solid rgb(0,0,0);border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:1.0000pt solid rgb(0,0,0);mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7844;P&nbsp;VIP</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=116 valign=center nowrap
					style="width:116.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:1.0000pt solid rgb(0,0,0);mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&#272;I&#7872;U&nbsp;KI&#7878;N&nbsp;N&#194;NG&nbsp;C&#7844;P</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=124 valign=center nowrap
					style="width:124.4500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:1.0000pt solid rgb(0,0,0);mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">THU&#7896;C&nbsp;T&#205;NH&nbsp;TH&#7900;I&nbsp;GIAN</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=104 valign=center nowrap
					style="width:104.0000pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:1.0000pt solid rgb(0,0,0);mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">THU&#7896;C&nbsp;T&#205;NH&nbsp;CHI&#7870;T&nbsp;KH&#7844;U</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
			</tr>
			<tr style="height:57.0000pt;">
				<td width=65 valign=center nowrap
					style="width:65.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:1.0000pt solid rgb(0,0,0);mso-border-left-alt:0.5000pt solid rgb(0,0,0);border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">VIP1</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=116 valign=center nowrap
					style="width:116.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">Nh&#7853;n&nbsp;ng&#432;&#7901;i&nbsp;gi&#7899;i&nbsp;thi&#7879;u&nbsp;n&#7841;p&nbsp;ti&#7873;n&nbsp;1&nbsp;l&#7847;n</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p>&nbsp;</o:p>
						</span></p>
				</td>
				<td width=124 valign=center
					style="width:124.4500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;1&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;60&nbsp;ng&#224;y</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;2&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;90&nbsp;ng&#224;y</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;3&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;120&nbsp;ng&#224;y</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;4&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;150&nbsp;ng&#224;y</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=104 valign=center
					style="width:104.0000pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=justify
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:justify;text-justify:inter-ideograph;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;1&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;5%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;2&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;3%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;3&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;2%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;4&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;1%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
			</tr>
			<tr style="height:54.0000pt;">
				<td width=65 valign=center
					style="width:65.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:1.0000pt solid rgb(0,0,0);mso-border-left-alt:0.5000pt solid rgb(0,0,0);border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">VIP2</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=116 valign=center
					style="width:116.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#243;&nbsp;8&nbsp;ng&#432;&#7901;i&nbsp;d&#249;ng&nbsp;VIP8</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=124 valign=center
					style="width:124.4500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=justify
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:justify;text-justify:inter-ideograph;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;1&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;90&nbsp;ng&#224;y</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;2&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;120&nbsp;ng&#224;y</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;3&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;150&nbsp;ng&#224;y</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;4&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;180&nbsp;ng&#224;y</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=104 valign=center
					style="width:104.0000pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;1&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;6%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;2&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;4%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;3&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;3%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;4&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;2%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
			</tr>
			<tr style="height:54.0000pt;">
				<td width=65 valign=center
					style="width:65.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:1.0000pt solid rgb(0,0,0);mso-border-left-alt:0.5000pt solid rgb(0,0,0);border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">VIP3</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=116 valign=center
					style="width:116.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#243;&nbsp;4&nbsp;ng&#432;&#7901;i&nbsp;d&#249;ng&nbsp;VIP2</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=124 valign=center
					style="width:124.4500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;1&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;120&nbsp;ng&#224;y</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;2&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;150&nbsp;ng&#224;y</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;3&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;180&nbsp;ng&#224;y</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;4&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;210&nbsp;ng&#224;y</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=104 valign=center
					style="width:104.0000pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;1&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;7%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;2&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;5%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;3&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;4%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;4&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;3%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
			</tr>
			<tr style="height:54.0000pt;">
				<td width=65 valign=center
					style="width:65.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:1.0000pt solid rgb(0,0,0);mso-border-left-alt:0.5000pt solid rgb(0,0,0);border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">VIP4</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=116 valign=center
					style="width:116.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#243;&nbsp;2&nbsp;ng&#432;&#7901;i&nbsp;d&#249;ng&nbsp;VIP3</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=124 valign=center
					style="width:124.4500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;1&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;150&nbsp;ng&#224;y</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;2&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;180&nbsp;ng&#224;y</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;3&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;210&nbsp;ng&#224;y</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;4&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;240&nbsp;ng&#224;y</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=104 valign=center
					style="width:104.0000pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;1&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;8%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;2&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;6%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;3&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;5%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;4&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;4%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
			</tr>
			<tr style="height:54.0000pt;">
				<td width=65 valign=center
					style="width:65.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:1.0000pt solid rgb(0,0,0);mso-border-left-alt:0.5000pt solid rgb(0,0,0);border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">VIP5</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=116 valign=center
					style="width:116.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#243;&nbsp;1&nbsp;ng&#432;&#7901;i&nbsp;d&#249;ng&nbsp;VIP4</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=124 valign=center
					style="width:124.4500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">M&#195;I&nbsp;M&#195;I</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=104 valign=center
					style="width:104.0000pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;1&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;10%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;2&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;8%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;3&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;6%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="text-autospace:ideograph-numeric;mso-pagination:widow-orphan;text-align:center;vertical-align:middle;">
						<span
							style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">C&#7845;p&nbsp;4&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;5%</span><span
							style="font-family:'Times New Roman';mso-fareast-font-family:宋体;font-style:normal;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
			</tr>
		</table>
		<p class=MsoNormal align=justify
			style="text-autospace:ideograph-numeric;mso-pagination:none;text-align:justify;text-justify:inter-ideograph;">
			<span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p>&nbsp;</o:p>
			</span></p>
		<p class=MsoNormal style="mso-para-margin-left:0.0000gd;text-autospace:ideograph-numeric;mso-pagination:none;">
			<b><span
					style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;">III.GI&#7842;I&nbsp;TH&#205;CH&nbsp;&#272;&#7862;C&nbsp;BI&#7878;T</span></b><b><span
					style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
					<o:p></o:p>
				</span></b></p>
		<p class=MsoNormal style="text-autospace:ideograph-numeric;mso-pagination:none;"><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">C&#417;&nbsp;ch&#7871;&nbsp;chi&#7871;t&nbsp;kh&#7845;u&nbsp;gi&#7899;i&nbsp;thi&#7879;u&nbsp;c&#243;&nbsp;th&#7875;&nbsp;&#273;&#432;&#7907;c&nbsp;&#273;i&#7873;u&nbsp;ch&#7881;nh&nbsp;trong&nbsp;th&#7901;i&nbsp;gian&nbsp;th&#7921;c&nbsp;t&#249;y&nbsp;theo&nbsp;t&#236;nh&nbsp;h&#236;nh&nbsp;th&#7883;&nbsp;tr&#432;&#7901;ng.&nbsp;GEX&nbsp;b&#7843;o&nbsp;l&#432;u&nbsp;quy&#7873;n&nbsp;gi&#7843;i&nbsp;th&#237;ch&nbsp;cu&#7889;i&nbsp;c&#249;ng&nbsp;v&#7873;&nbsp;c&#417;&nbsp;ch&#7871;&nbsp;n&#224;y.&nbsp;Vui&nbsp;l&#242;ng&nbsp;tham&nbsp;kh&#7843;o&nbsp;th&#244;ng&nbsp;b&#225;o&nbsp;ch&#237;nh&nbsp;th&#7913;c&nbsp;c&#7911;a&nbsp;GEX&nbsp;&#273;&#7875;&nbsp;bi&#7871;t&nbsp;t&#7845;t&nbsp;c&#7843;&nbsp;c&#225;c&nbsp;thay&nbsp;&#273;&#7893;i&nbsp;v&#7873;&nbsp;quy&nbsp;t&#7855;c.</span><span
				style="mso-spacerun:'yes';font-family:'Times New Roman';mso-fareast-font-family:宋体;letter-spacing:0.0000pt;text-transform:none;font-style:normal;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span></p>
	</div>
	<!--EndFragment-->
</body>`,
      th:`<body style="tab-interval:21pt;text-justify-trim:punctuation;">
	<!--StartFragment-->
	<div class="Section0" style="layout-grid:15.6000pt;">
		<p class=MsoNormal align=center style="text-align:center;"><b><span
					style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-weight:bold;font-size:14.0000pt;mso-font-kerning:1.0000pt;">ประกาศเปิดตัวกิจกรรมรางวัลคำเชิญ</span></b><b><span
					style="mso-spacerun:'yes';font-family:宋体;font-weight:bold;font-size:14.0000pt;mso-font-kerning:1.0000pt;">
					<o:p></o:p>
				</span></b></p>
		<p class=MsoNormal align=center style="text-align:center;"><b><span
					style="mso-spacerun:'yes';font-family:宋体;font-weight:bold;font-size:14.0000pt;mso-font-kerning:1.0000pt;">
					<o:p>&nbsp;</o:p>
				</span></b></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">เรียนผู้ใช้</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">GEX</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal style="text-indent:21.0000pt;mso-char-indent-count:2.0000;"><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">GEX&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">จะเปิดตัวกิจกรรมการรางวัลการเชิญในวันที่</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">30&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">มิถุนายน</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">2022&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">กิจกรรมการคำเชิญมีวัตถุประสงค์เพื่อให้รางวัลแก่ผู้ใช้ที่เครดิตดีของ</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">GEX&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">เพื่อแบ่งปันความสนุกในการซื้อขายบน</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">GEX&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">ให้กับ</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">เพื่อน</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">ๆ</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">ของคุณ</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">&nbsp;เพียงแค่</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">ผู้ใช้ที่เชิญมีคุณสมบัติตรงตามเงื่อนไขการรับรางวัลค่าคอมมิชชัน</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">ผู้เชิญสามารถรับรางวัลค่าคอมมิชชันได้ถึงสี่รุ่น</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal style="text-indent:21.0000pt;mso-char-indent-count:2.0000;"><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p>&nbsp;</o:p>
			</span></p>
		<p class=MsoNormal><b><span
					style="mso-spacerun:'yes';font-family:宋体;font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
					<o:p>&nbsp;</o:p>
				</span></b></p>
		<p class=MsoNormal><b><span
					style="mso-spacerun:'yes';font-family:宋体;font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">1.&nbsp;</span></b><b><span
					style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">อัตราส่วนเงินคืน</span></b><b><span
					style="mso-spacerun:'yes';font-family:宋体;font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
					<o:p></o:p>
				</span></b></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">การพัฒนาสมาชิกระบุไว้ดังนี้</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">:&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">ผู้แนะนำ</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">&#62;&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">ดาวน์ไลน์</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">รุ่นที่&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">1</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">&#62;&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">ดาวน์ไลน์</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">รุ่นที่</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">2</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">&#62;&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">ดาวน์ไลน์</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">รุ่นที่</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">3</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">&#62;&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">ดาวน์ไลน์</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">รุ่นที่</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">4</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">&nbsp;(</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">มากถึงสี่ดาวน์ไลน์</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">)</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">ผู้แนะนำสามารถรับเงินคืนจากเงินฝาก</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">5%&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">ของ</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">ดาวน์ไลน์</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">ระดับ&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">1</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">ผู้แนะนำสามารถรับเงินคืนจากเงินฝาก</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">3%</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">ของ</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">ดาวน์ไลน์</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">ระดับ&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">2</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">ผู้แนะนำสามารถรับเงินคืนจากเงินฝาก</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">2%</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">ของ</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">ดาวน์ไลน์</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">ระดับ&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">3</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">ผู้แนะนำสามารถรับเงินคืนจากเงินฝาก</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">1%&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">ของ</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">ดาวน์ไลน์</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">ระดับ&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">4</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
				<o:p>&nbsp;</o:p>
			</span></p>
		<p class=MsoNormal><b><span
					style="mso-spacerun:'yes';font-family:宋体;font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;">1.&nbsp;</span></b><b><span
					style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;">กลไกการรับเงินคืน</span></b><b><span
					style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
					<o:p></o:p>
				</span></b></p>
		<p class=MsoNormal><b><span
					style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
					<o:p>&nbsp;</o:p>
				</span></b></p>
		<p class=MsoNormal><b><span
					style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
					<o:p>&nbsp;</o:p>
				</span></b></p>
		<p class=MsoNormal><b><span
					style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
					<o:p>&nbsp;</o:p>
				</span></b></p>
		<p class=MsoNormal><b><span
					style="mso-spacerun:'yes';font-family:宋体;font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
					<o:p>&nbsp;</o:p>
				</span></b></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">1.&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">ผู้เชิญต้องเชิญเพื่อนให้ลงทะเบียนบนแพลตฟอร์ม</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">GEX&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">ผ่านรหัสเชิญหรือลิงก์คำเชิญ</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">และยืนยันความสัมพันธ์ในการรับคืนเงินคำเชิญ</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">2.&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">หลังจากที่ผู้ใช้ที่ได้รับเชิญและเสร็จสิ้นการลงทะเบียนโดยใช้รหัสเชิญหรือลิงก์คำเชิญ</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">จะมีการคืนเงินสำหรับการฝากแต่ละครั้งตามที่กำหนด</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">3.&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">รางวัลคอมมิชชั่นจเข้าไปยังบัญชีสกุลเงินของคุณเป็นสกุลเงิน</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">USDT</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">4.&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">รางวัล</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">เงินคืนเพื่อนจะคำนวณในวันเดียวกัน&nbsp;และโอนเข้าบัญชีในวันถัดไป</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">จำนวนรางวัลเงินคืน</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">&nbsp;=&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">จำนวนเงินฝากจริง</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">&nbsp;*&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">อัตราส่วนเงินคืน</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">5.&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">ระยะเวลาที่ใช้ได้ของเงินคืนเงินฝากของเพื่อนผู้แนะนำจะคำนวณจากเวลาลงทะเบียนจริง</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">หลังจากหมดระยะเวลาที่กำหนด</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">คุณจะไม่ได้รับเงินคืนเงินฝากของผู้แนะนำ</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">ผู้แนะนำสามารถพัฒนาระดับวีไอพีของคุณโดยการอัพระดับวีไอพีของคุณเพื่อยืดเวลาเงินคืนและอัพอัตราส่วนเงินคืน</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p>&nbsp;</o:p>
			</span></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">1.&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">แผนภาพ</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">VIP</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p>&nbsp;</o:p>
			</span></p>
		<table class=MsoNormalTable border=0 cellspacing=0
			style="border-collapse:collapse;width:454.3500pt;margin-left:4.6500pt;border:none;mso-padding-alt:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;">
			<tr style="height:36.0000pt;">
				<td width=65 valign=center nowrap
					style="width:65.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:1.0000pt solid rgb(0,0,0);mso-border-left-alt:0.5000pt solid rgb(0,0,0);border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:1.0000pt solid rgb(0,0,0);mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">ระดับ&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">VIP</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=116 valign=center nowrap
					style="width:116.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:1.0000pt solid rgb(0,0,0);mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">เงื่อนไขการอัพเดต</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=138 valign=center nowrap
					style="width:138.2000pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:1.0000pt solid rgb(0,0,0);mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">ระยะเวลา</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=134 valign=center nowrap
					style="width:134.6500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:1.0000pt solid rgb(0,0,0);mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">อัตราเงินคืน</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
			</tr>
			<tr style="height:57.0000pt;">
				<td width=65 valign=center nowrap
					style="width:65.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:1.0000pt solid rgb(0,0,0);mso-border-left-alt:0.5000pt solid rgb(0,0,0);border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">VIP1</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=116 valign=center nowrap
					style="width:116.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">รับเงินฝากผู้แนะนำครั้งเดียว</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=138 valign=center
					style="width:138.2000pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับหนึ่ง&nbsp;</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">6</span><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">0&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">วัน</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับสอง&nbsp;</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">9</span><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">0&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">วัน</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับสาม&nbsp;</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">1</span><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">20&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">วัน</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับสี่&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">150&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">วัน</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p>&nbsp;</o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=134 valign=center
					style="width:134.6500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับหนึ่ง&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">5%&nbsp;&nbsp;&nbsp;</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับสอง&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">3%</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับสาม&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">2%</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับสี่&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">1%</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p>&nbsp;</o:p>
						</span></p>
				</td>
			</tr>
			<tr style="height:97.3000pt;">
				<td width=65 valign=center
					style="width:65.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:1.0000pt solid rgb(0,0,0);mso-border-left-alt:0.5000pt solid rgb(0,0,0);border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">VIP2</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=116 valign=center
					style="width:116.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">傘下8個VIP1用戶、</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">ภายใต้ผู้ใช้&nbsp;</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">8</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">คน&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">VIP1</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=138 valign=center
					style="width:138.2000pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับหนึ่ง&nbsp;</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">9</span><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">0&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">วัน</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับสอง&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">120&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">วัน</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับสาม&nbsp;</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">1</span><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">50&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">วัน</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับสี่&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">180&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">วัน</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p>&nbsp;</o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p>&nbsp;</o:p>
						</span></p>
				</td>
				<td width=134 valign=center
					style="width:134.6500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับหนึ่ง&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">6%&nbsp;&nbsp;&nbsp;</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับสอง&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">4%</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับสาม&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">3%&nbsp;&nbsp;&nbsp;</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับสี่&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">2%</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p>&nbsp;</o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p>&nbsp;</o:p>
						</span></p>
				</td>
			</tr>
			<tr style="height:85.9000pt;">
				<td width=65 valign=center
					style="width:65.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:1.0000pt solid rgb(0,0,0);mso-border-left-alt:0.5000pt solid rgb(0,0,0);border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">VIP3</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=116 valign=center
					style="width:116.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">ภายใต้ผู้ใช้&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">4&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">คน&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">VIP</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">2</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=138 valign=center
					style="width:138.2000pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับหนึ่ง&nbsp;</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">1</span><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">20&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">วัน</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับสอง&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">150</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">วัน</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับสาม&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">180</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">วัน</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับสี่&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">210</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">วัน</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p>&nbsp;</o:p>
						</span></p>
				</td>
				<td width=134 valign=center
					style="width:134.6500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับหนึ่ง&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">7%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับสอง&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">5%</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับสาม&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">4%&nbsp;&nbsp;&nbsp;</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับสี่&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">3%</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p>&nbsp;</o:p>
						</span></p>
				</td>
			</tr>
			<tr style="height:111.3000pt;">
				<td width=65 valign=center
					style="width:65.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:1.0000pt solid rgb(0,0,0);mso-border-left-alt:0.5000pt solid rgb(0,0,0);border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">VIP4</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=116 valign=center
					style="width:116.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">ภายใต้ผู้ใช้&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">2&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">คน&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">VIP</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">3</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=138 valign=center
					style="width:138.2000pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับหนึ่ง&nbsp;</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">1</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">50</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">วัน</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับสอง&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">180</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">วัน</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับสาม&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">210</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">วัน</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับสี่</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">2</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">40</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">วัน</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p>&nbsp;</o:p>
						</span></p>
				</td>
				<td width=134 valign=center
					style="width:134.6500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับหนึ่ง&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">8%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับสอง&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">6%&nbsp;&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับสาม&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">5%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับสี่&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">4%</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p>&nbsp;</o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p>&nbsp;</o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p>&nbsp;</o:p>
						</span></p>
				</td>
			</tr>
			<tr style="height:54.0000pt;">
				<td width=65 valign=center
					style="width:65.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:1.0000pt solid rgb(0,0,0);mso-border-left-alt:0.5000pt solid rgb(0,0,0);border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">VIP5</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=116 valign=center
					style="width:116.2500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">ภายใต้ผู้ใช้&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">1&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">คน&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">VIP</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">4</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=138 valign=center
					style="width:138.2000pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">&nbsp;</span><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">ถาวร</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
				</td>
				<td width=134 valign=center
					style="width:134.6500pt;padding:0.0000pt 5.4000pt 0.0000pt 5.4000pt ;border-left:none;mso-border-left-alt:none;border-right:1.0000pt solid rgb(0,0,0);mso-border-right-alt:0.5000pt solid rgb(0,0,0);border-top:none;mso-border-top-alt:0.5000pt solid rgb(0,0,0);border-bottom:1.0000pt solid rgb(0,0,0);mso-border-bottom-alt:0.5000pt solid rgb(0,0,0);">
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับหนึ่ง&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">10%&nbsp;&nbsp;&nbsp;</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับสอง&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">8%&nbsp;&nbsp;&nbsp;&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับสาม&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">6%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:0.0000pt;">เงินคืนดาวน์ไลน์ระดับสี่&nbsp;</span><span
							style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:0.0000pt;">5%</span><span
							style="font-family:宋体;mso-bidi-font-family:'Cordia New';font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p></o:p>
						</span></p>
					<p class=MsoNormal align=center
						style="mso-pagination:widow-orphan;text-align:center;vertical-align:middle;"><span
							style="font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
							<o:p>&nbsp;</o:p>
						</span></p>
				</td>
			</tr>
		</table>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p>&nbsp;</o:p>
			</span></p>
		<p class=MsoNormal><b><span
					style="mso-spacerun:'yes';font-family:宋体;font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;">3.&nbsp;</span></b><b><span
					style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;">คำแนะนำพิเศษ</span></b><b><span
					style="mso-spacerun:'yes';font-family:宋体;font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
					<o:p></o:p>
				</span></b></p>
		<p class=MsoNormal><b><span
					style="mso-spacerun:'yes';font-family:宋体;font-weight:bold;font-size:10.5000pt;mso-font-kerning:1.0000pt;">
					<o:p>&nbsp;</o:p>
				</span></b></p>
		<p class=MsoNormal><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">กลไกการคืนเงินคำเชิญอาจปรับเปลี่ยนตามเวลาจริงตามสภาวะตลาด&nbsp;และ</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">GEX&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">ขอสงวนสิทธิ์ในการตีความขั้นสุดท้ายของกลไก</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">โปรดดูประกาศการเปลี่ยนแปลงกฎทั้งหมดอย่างเป็นทางการของ</span><span
				style="mso-spacerun:'yes';font-family:宋体;mso-bidi-font-family:'Angsana New';font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">&nbsp;</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">GEX</span><span
				style="mso-spacerun:'yes';font-family:宋体;font-size:10.5000pt;mso-font-kerning:1.0000pt;;mso-shading:rgb(255,255,255);">
				<o:p></o:p>
			</span></p>
	</div>
	<!--EndFragment-->
</body>`
    }
        }
    },
    onLoad() {
			uni.setNavigationBarTitle({
				title:this.$t('financial.tggz')
			})
            var token = uni.getStorageSync('token');
			if (token) {
				this.getUserInfo();
			}
	},
    onShow() {
		   this.$utils.setThemeTop(this.theme)
		  // this.getList()
		},
    computed:{
        ...mapState(['theme']),
        
          content(){
            var lang=uni.getStorageSync('lang') || 'en';
            return this.tran[lang] || this.tran.en
          }
        
    },
    methods:{
        getUserInfo() {
				var that = this;
				this.$utils.initDataToken({ url: 'user/info', data: {}, type: 'get' }, (res, msg) => {
					that.info = res;
				});
			},
    }
}
</script>

<style>

</style>