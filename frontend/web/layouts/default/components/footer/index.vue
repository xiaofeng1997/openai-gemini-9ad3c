<template>
    <div class="flex min-w-[1200px] fixed bottom-0 left-0 right-0">
		<div class="mt-[70px] w-full">
            <p class="text-center text-[#666]" v-if="friendlyLink.length">
				<span>友情链接：</span>
				<template v-for="(item,index) in friendlyLink" :key="index">
					<NuxtLink :to="item.link_url" target="_blank">
						<span>{{item.link_title}}</span>
						<span class="mx-[10px] text-[#666]"  v-if="(index + 1) != friendlyLink.length">|</span>
					</NuxtLink>
				</template>
			</p>
            <p class="text-center mt-[20px] text-[#666]" v-if="copyright">
                <NuxtLink :to="copyright.gov_url" v-if="copyright.gov_record">
                    <span class="mr-2">公安备案号:{{ copyright.gov_record }}</span>
                </NuxtLink>
				<NuxtLink to="https://beian.miit.gov.cn/" v-if="copyright.icp">
					<span class="mr-2">备案号:{{ copyright.icp }}</span>
				</NuxtLink>
                <NuxtLink :to="copyright.copyright_link">
                    <span class="mr-2" v-if="copyright.company_name">{{ copyright.company_name }}</span>
                    <span class="mr-2" v-if="copyright.copyright_desc">©{{ copyright.copyright_desc }}</span>
                </NuxtLink>
			</p>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { getCopyRight } from '@/api/system';
import { getSiteInfo } from '@/stores/system';
import { reactive, ref } from 'vue'

const copyright = ref(null);
const getCopy = () => {
    getCopyRight().then(({ data }) => {
        copyright.value = data
    })
}
getCopy()

const friendlyLink = ref([
    { link_title: 'niushop', link_url: 'https://www.niushop.com' },
    { link_title: 'niucloud', link_url: 'https://www.niucloud.com' },
    { link_title: '知乎', link_url: 'https://www.zhihu.com' }
]) // 格式：{ link_title: '', link_url: '' }
</script>

<style lang="scss" scoped>

</style>
