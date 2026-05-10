<template>
    <div class="volunteer-container">
        <div class="header">
            <div class="container">
                <h1 class="title">志愿者服务</h1>
                <div class="subtitle">用积分兑换邻里互助服务</div>
            </div>
        </div>

        <div class="container">
            <div class="category-tabs" v-if="categoryList.length">
                <div class="tab-item" :class="{ active: categoryId === 0 }" @click="changeCategory(0)">
                    全部
                </div>
                <div class="tab-item" :class="{ active: categoryId === item.category_id }" v-for="item in categoryList" :key="item.category_id" @click="changeCategory(item.category_id)">
                    {{ item.category_name }}
                </div>
            </div>

            <div class="service-grid" v-if="serviceList.length || loading">
                <div class="service-card" v-for="item in serviceList" :key="item.service_id" @click="goDetail(item.service_id)">
                    <div class="service-cover">
                        <img v-if="imageLoaded[item.service_id]" :src="item.service_cover" :alt="item.service_name" />
                        <div v-else class="cover-placeholder">🛠️</div>
                    </div>
                    <div class="service-info">
                        <h3 class="service-name">{{ item.service_name }}</h3>
                        <div class="service-meta">
                            <span class="point">{{ item.point_price }} 积分</span>
                            <span class="duration">{{ item.service_duration }}分钟</span>
                        </div>
                        <div class="service-category">{{ item.category_name || '其他服务' }}</div>
                    </div>
                </div>
            </div>

            <div class="empty" v-else-if="!loading">
                <p>暂无服务</p>
            </div>

            <div class="loading-more" v-if="loading && serviceList.length">
                <span>加载中...</span>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'
import { getVolunteerIndex, getServiceLists } from '@/api/volunteer'

const router = useRouter()

const categoryList = ref<any[]>([])
const categoryId = ref(0)
const serviceList = ref<any[]>([])
const loading = ref(false)
const page = ref(1)
const hasMore = ref(true)
const imageLoaded = ref<Record<string, boolean>>({})

onMounted(() => {
    loadIndex()
    loadService()
    window.addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll)
})

const loadIndex = async () => {
    try {
        const res: any = await getVolunteerIndex()
        categoryList.value = res.data?.category || []
        if (res.data?.service_list?.length && !serviceList.value.length) {
            serviceList.value = res.data.service_list.slice(0, 6)
            preloadImages(res.data.service_list.slice(0, 6))
        }
    } catch (e) {
        console.error(e)
    }
}

const changeCategory = (id: number) => {
    categoryId.value = id
    page.value = 1
    hasMore.value = true
    serviceList.value = []
    imageLoaded.value = {}
    loadService()
}

const loadService = async () => {
    if (loading.value || !hasMore.value) return
    loading.value = true
    try {
        const res: any = await getServiceLists({
            category_id: categoryId.value,
            page: page.value,
            limit: 20
        })
        const newList = res.data?.data || []
        preloadImages(newList)

        if (page.value === 1) {
            serviceList.value = newList
        } else {
            serviceList.value = [...serviceList.value, ...newList]
        }

        if (newList.length < 20) {
            hasMore.value = false
        }
    } catch (e) {
        console.error(e)
    } finally {
        loading.value = false
    }
}

const preloadImages = (list: any[]) => {
    list.forEach((item: any) => {
        if (!imageLoaded.value[item.service_id]) {
            imageLoaded.value[item.service_id] = false
            const img = new Image()
            img.onload = () => {
                imageLoaded.value[item.service_id] = true
            }
            img.src = item.service_cover
        }
    })
}

const handleScroll = () => {
    const scrollTop = document.documentElement.scrollTop || document.body.scrollTop
    const clientHeight = document.documentElement.clientHeight
    const scrollHeight = document.documentElement.scrollHeight

    if (scrollTop + clientHeight >= scrollHeight - 200 && !loading.value && hasMore.value) {
        page.value++
        loadService()
    }
}

const goDetail = (service_id: number) => {
    router.push(`/web/volunteer/detail/${service_id}`)
}
</script>

<style scoped lang="scss">
.volunteer-container {
    min-height: 100vh;
    background: #f5f5f5;
}

.header {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    padding: 60px 0;
    color: #fff;

    .container {
        text-align: center;
    }

    .title {
        font-size: 36px;
        font-weight: bold;
        margin: 0 0 12px;
    }

    .subtitle {
        font-size: 16px;
        opacity: 0.9;
    }
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.category-tabs {
    display: flex;
    gap: 16px;
    padding: 30px 0;
    overflow-x: auto;
    scrollbar-width: none;

    &::-webkit-scrollbar {
        display: none;
    }

    .tab-item {
        padding: 10px 24px;
        background: #fff;
        border-radius: 20px;
        font-size: 14px;
        color: #666;
        cursor: pointer;
        white-space: nowrap;
        transition: all 0.3s;

        &:hover {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        &.active {
            background: #11998e;
            color: #fff;
        }
    }
}

.service-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    padding-bottom: 60px;

    @media (max-width: 1024px) {
        grid-template-columns: repeat(2, 1fr);
    }

    @media (max-width: 768px) {
        grid-template-columns: 1fr;
    }
}

.service-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    cursor: pointer;
    transition: transform 0.3s, box-shadow 0.3s;

    &:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .service-cover {
        width: 100%;
        height: 180px;
        background: #f5f5f5;

        img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cover-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
        }
    }

    .service-info {
        padding: 16px;

        .service-name {
            font-size: 16px;
            color: #333;
            margin: 0 0 12px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 44px;
        }

        .service-meta {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 8px;

            .point {
                color: #11998e;
                font-size: 18px;
                font-weight: bold;
            }

            .duration {
                color: #999;
                font-size: 12px;
            }
        }

        .service-category {
            font-size: 12px;
            color: #666;
        }
    }
}

.loading-more {
    text-align: center;
    padding: 30px;
    color: #999;
    font-size: 14px;
}

.empty {
    text-align: center;
    padding: 100px 0;
    color: #999;
    font-size: 16px;
}
</style>
