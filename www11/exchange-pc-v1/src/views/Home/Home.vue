<template>
    <div>
        <Banner />

        <MatchSwiper />

        <div class="bg-white">
            <div class="max-w-[1200px] mx-auto py-30">
                <MatchInfo />

                <CompanyDesc1 />
            </div>
        </div>

        <div class="bg-#F6F7F8">
            <div class="max-w-[1200px] mx-auto py-40">
                <AppDownload />
            </div>
        </div>

        <div class="bg-white">
            <div class="max-w-[1200px] mx-auto py-40">
                <CompanyDesc2 />
            </div>
        </div>

        <div class="bg-#F6F7F8">
            <div class="max-w-[1200px] mx-auto py-50 text-black text-center">
               <CompanyStart />
            </div>
        </div>

        <div class="bg-#161616">
            <div class="max-w-[1200px] mx-auto py-80">
                <CompanyDesc3 />
            </div>
        </div>


        <div class="bg-#161616">
            <div class="max-w-[1200px] mx-auto py-80">
                <Footer />
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import Banner from './components/Banner.vue';
import MatchSwiper from './components/MatchSwiper.vue'
import MatchInfo from './components/MatchInfo.vue'
import CompanyDesc1 from './components/CompanyDesc1.vue'
import AppDownload from './components/AppDownload.vue'
import CompanyDesc2 from './components/CompanyDesc2.vue'
import CompanyDesc3 from './components/CompanyDesc3.vue'
import CompanyStart from './components/CompanyStart.vue';
import Footer from '@/components/Footer/index.vue'
</script>