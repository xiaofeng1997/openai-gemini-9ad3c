<template>
    <div class="volunteer-container">
        <div class="header">
            <h1 class="title">志愿者服务</h1>
            <div class="subtitle">用积分兑换邻里互助服务</div>
        </div>
        
        <div class="category-tabs">
            <div 
                v-for="item in categoryList" 
                :key="item.id"
                :class="['tab', { active: currentCategory === item.id }]"
                @click="switchCategory(item.id)"
            >
                {{ item.name }}
            </div>
        </div>

        <div class="service-list" v-if="list.length > 0">
            <div 
                v-for="item in list" 
                :key="item.id"
                class="service-card"
                @click="goDetail(item.id)"
            >
                <image 
                    class="service-image" 
                    :src="getImagePath(item.image)" 
                    mode="aspectFill"
                    :lazy-load="true"
                />
                <div class="service-info">
                    <div class="service-name">{{ item.name }}</div>
                    <div class="service-desc">{{ item.desc }}</div>
                    <div class="service-bottom">
                        <text class="points">{{ item.points }} 积分</text>
                        <text class="volunteer">志愿者: {{ item.volunteer_name || '平台' }}</text>
                    </div>
                </div>
            </div>
            
            <div class="loading-more" v-if="loading">
                <text>加载中...</text>
            </div>
            <div class="no-more" v-else-if="list.length >= total">
                <text>没有更多了</text>
            </div>
        </div>

        <div class="empty-state" v-else-if="!loading">
            <image class="empty-icon" src="/static/images/empty.png" mode="aspectFit" />
            <text class="empty-text">暂无相关服务</text>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { getVolunteerIndex, getServiceLists } from '@/api/volunteer'

const currentCategory = ref(0)
const categoryList = ref<any[]>([])
const list = ref<any[]>([])
const loading = ref(false)
const page = ref(1)
const total = ref(0)

const getImagePath = (path: string) => {
    if (!path) return '/static/images/default.png'
    if (path.startsWith('http')) return path
    return import.meta.env.VITE_APP_IMG_URL + path
}

const loadIndex = async () => {
    try {
        const res = await getVolunteerIndex()
        categoryList.value = res.category || []
    } catch (error) {
        console.error('加载首页数据失败', error)
    }
}

const loadList = async () => {
    if (loading.value) return
    loading.value = true
    
    try {
        const params: any = { page: page.value, limit: 10 }
        if (currentCategory.value) {
            params.category_id = currentCategory.value
        }
        
        const res = await getServiceLists(params)
        
        if (page.value === 1) {
            list.value = res.lists || []
        } else {
            list.value = [...list.value, ...(res.lists || [])]
        }
        total.value = res.count || 0
    } catch (error) {
        console.error('加载服务列表失败', error)
    } finally {
        loading.value = false
    }
}

const switchCategory = (id: number) => {
    currentCategory.value = id
    page.value = 1
    list.value = []
    loadList()
}

const goDetail = (id: number) => {
    uni.navigateTo({ url: `/pages/member/volunteer_detail?id=${id}` })
}

onMounted(() => {
    loadIndex()
    loadList()
})

onReachBottom(() => {
    if (list.value.length < total.value) {
        page.value++
        loadList()
    }
})
</script>

<style lang="scss" scoped>
.volunteer-container {
    min-height: 100vh;
    background: #f5f5f5;
}

.header {
    background: linear-gradient(135deg, #1890ff, #096dd9);
    padding: 60rpx 30rpx 80rpx;
    
    .title {
        font-size: 44rpx;
        font-weight: 600;
        color: #fff;
        margin-bottom: 12rpx;
    }
    
    .subtitle {
        font-size: 28rpx;
        color: rgba(255, 255, 255, 0.8);
    }
}

.category-tabs {
    display: flex;
    gap: 24rpx;
    padding: 24rpx 30rpx;
    background: #fff;
    margin: -40rpx 30rpx 0;
    border-radius: 16rpx 16rpx 0 0;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    
    &::-webkit-scrollbar {
        display: none;
    }
}

.tab {
    flex-shrink: 0;
    padding: 12rpx 24rpx;
    font-size: 28rpx;
    color: #666;
    background: #f5f5f5;
    border-radius: 32rpx;
    
    &.active {
        color: #fff;
        background: #1890ff;
    }
}

.service-list {
    padding: 20rpx 30rpx 30rpx;
    background: #fff;
    margin: 0 30rpx;
    border-radius: 0 0 16rpx 16rpx;
}

.service-card {
    display: flex;
    gap: 20rpx;
    padding: 24rpx 0;
    border-bottom: 1rpx solid #f0f0f0;
    
    &:last-child {
        border-bottom: none;
    }
}

.service-image {
    width: 200rpx;
    height: 200rpx;
    border-radius: 12rpx;
    background: #f5f5f5;
}

.service-info {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.service-name {
    font-size: 30rpx;
    font-weight: 500;
    color: #333;
    margin-bottom: 8rpx;
}

.service-desc {
    font-size: 26rpx;
    color: #999;
    flex: 1;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.service-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 12rpx;
    
    .points {
        font-size: 28rpx;
        font-weight: 600;
        color: #ff6b00;
    }
    
    .volunteer {
        font-size: 24rpx;
        color: #999;
    }
}

.loading-more,
.no-more {
    text-align: center;
    padding: 30rpx;
    font-size: 26rpx;
    color: #999;
}

.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 120rpx 0;
}

.empty-icon {
    width: 200rpx;
    height: 200rpx;
    opacity: 0.5;
}

.empty-text {
    font-size: 28rpx;
    color: #999;
    margin-top: 24rpx;
}
</style>
