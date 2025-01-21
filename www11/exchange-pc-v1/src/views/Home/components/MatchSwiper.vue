<template>
    <div class="w-full overflow-x-hidden">
        <swiper :slidesPerView="6" :speed="10000" loop :spaceBetween="1" :autoplay="{ delay: 0 }" :modules="modules">
            <swiper-slide v-for="match in matchList">
                <div class="w-260 flex flex-col items-center justify-center py-30">
                    <div class="text-black">
                        {{ match.symbol }}
                    </div>
                    <div class="flex items-center justify-center scale-90">
                        <img v-if="+match.currency_quotation.change >= 0" class="w-16 h-16" src="@images/up.png">
                        <img v-else class="w-16 h-16" src="@images/down.png">
                        <span :class="[+match.currency_quotation.change >= 0 ? 'text-up' : 'text-down']">
                            {{ +match.currency_quotation.change >= 0 ? '+' : '' }}
                            {{ match.currency_quotation.change }}%
                        </span>
                    </div>
                </div>
            </swiper-slide>
        </swiper>
    </div>
</template>

<script lang="ts" setup>
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Autoplay } from 'swiper/modules';
import { Match } from '@/interface';
import { useMarketStore } from '@/store';

const modules = [Autoplay]

const { currencyMatches } = storeToRefs(useMarketStore())

const matchList = computed(() => {
    const match: Match[] = []
    currencyMatches.value.forEach((item) => {
        match.push(...item.matches)
    })
    return match
})

</script>

<style>
.swiper {
    background: linear-gradient(90deg, #FFF509 0%, #18FB8E 100%);
}

.swiper-wrapper {
    display: flex;
}
</style>