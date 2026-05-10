<template>
    <div class="point-shop-container">
        <div class="header">
            <div class="container">
                <h1 class="title">积分商城</h1>
                <div class="my-point" @click="goMyPoint">
                    <span class="point-icon">⭐</span>
                    <span>{{ memberPoint }} 积分</span>
                </div>
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

            <div class="goods-grid" v-if="goodsList.length || loading">
                <template v-if="loading && !goodsList.length">
                    <div class="goods-card skeleton" v-for="i in 8" :key="i">
                        <div class="skeleton-image"></div>
                        <div class="skeleton-content">
                            <div class="skeleton-title"></div>
                            <div class="skeleton-price"></div>
                        </div>
                    </div>
                </template>
                <template v-else>
                    <div class="goods-card" v-for="item in goodsList" :key="item.goods_id" @click="goDetail(item.goods_id)">
                        <div class="goods-image">
                            <img v-if="imageLoaded[item.goods_id]" :src="item.goods_image" :alt="item.goods_name" @error="handleImageError($event, item.goods_id)" />
                            <div v-else class="image-placeholder">
                                <div class="placeholder-icon">🛍️</div>
                            </div>
                        </div>
                        <div class="goods-info">
                            <h3 class="goods-name">{{ item.goods_name }}</h3>
                            <div class="goods-price">
                                <span class="point">{{ item.point_price }} 积分</span>
                                <span class="market">¥{{ item.price }}</span>
                            </div>
                            <div class="goods-stock">库存: {{ item.stock }}</div>
                        </div>
                    </div>
                </template>
            </div>

            <div class="empty" v-else-if="!loading">
                <p>暂无商品</p>
            </div>

            <div class="loading-more" v-if="loading && goodsList.length">
                <span>加载中...</span>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'
import { getPointShopIndex, getPointGoodsList } from '@/api/pointshop'
import useMemberStore from '@/stores/member'

const router = useRouter()
const memberStore = useMemberStore()

const memberPoint = ref(0)
const categoryList = ref<any[]>([])
const categoryId = ref(0)
const goodsList = ref<any[]>([])
const loading = ref(false)
const page = ref(1)
const imageLoaded = ref<Record<string, boolean>>({})

onMounted(() => {
    memberPoint.value = memberStore.info?.point || 0
    loadIndex()
    loadGoods()

    window.addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll)
})

const loadIndex = async () => {
    try {
        const res = await getPointShopIndex()
        categoryList.value = res.data.category || []
    } catch (e) {
        console.error(e)
    }
}

const changeCategory = (id: number) => {
    categoryId.value = id
    page.value = 1
    goodsList.value = []
    imageLoaded.value = {}
    loadGoods()
}

const loadGoods = async () => {
    loading.value = true
    try {
        const res = await getPointGoodsList({
            category_id: categoryId.value,
            page: page.value,
            limit: 20
        })
        const newList = res.data.data || []

        newList.forEach((item: any) => {
            if (!imageLoaded.value[item.goods_id]) {
                imageLoaded.value[item.goods_id] = false
                const img = new Image()
                img.onload = () => {
                    imageLoaded.value[item.goods_id] = true
                }
                img.src = item.goods_image
            }
        })

        if (page.value === 1) {
            goodsList.value = newList
        } else {
            goodsList.value = [...goodsList.value, ...newList]
        }
    } catch (e) {
        console.error(e)
    } finally {
        loading.value = false
    }
}

const handleScroll = () => {
    const scrollTop = document.documentElement.scrollTop || document.body.scrollTop
    const clientHeight = document.documentElement.clientHeight
    const scrollHeight = document.documentElement.scrollHeight

    if (scrollTop + clientHeight >= scrollHeight - 200 && !loading.value) {
        page.value++
        loadGoods()
    }
}

const handleImageError = (event: Event, goodsId: string) => {
    const img = event.target as HTMLImageElement
    img.style.display = 'none'
    imageLoaded.value[goodsId] = false
}

const goDetail = (goods_id: number) => {
    router.push(`/web/pointshop/detail/${goods_id}`)
}

const goMyPoint = () => {
    router.push('/web/member/point')
}
</script>

<style scoped lang="scss">
.point-shop-container {
    min-height: 100vh;
    background: #f5f5f5;
}

.header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 60px 0;
    color: #fff;
    position: sticky;
    top: 0;
    z-index: 100;

    .container {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .title {
        font-size: 36px;
        font-weight: bold;
        margin: 0;
    }

    .my-point {
        display: flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.2);
        padding: 12px 24px;
        border-radius: 30px;
        cursor: pointer;
        transition: background 0.3s;
        font-size: 16px;

        &:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .point-icon {
            font-size: 20px;
        }
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
            background: #667eea;
            color: #fff;
        }
    }
}

.goods-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
    padding-bottom: 60px;

    @media (max-width: 1024px) {
        grid-template-columns: repeat(3, 1fr);
    }

    @media (max-width: 768px) {
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }
}

.goods-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    cursor: pointer;
    transition: transform 0.3s, box-shadow 0.3s;

    &:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .goods-image {
        width: 100%;
        height: 200px;
        background: #f5f5f5;
        overflow: hidden;

        @media (max-width: 768px) {
            height: 160px;
        }

        img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: opacity 0.3s;
        }

        .image-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);

            .placeholder-icon {
                font-size: 48px;
                opacity: 0.5;
            }
        }
    }

    .goods-info {
        padding: 16px;

        .goods-name {
            font-size: 16px;
            color: #333;
            margin: 0 0 12px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 44px;
            line-height: 1.4;

            @media (max-width: 768px) {
                font-size: 14px;
                height: 40px;
            }
        }

        .goods-price {
            display: flex;
            align-items: baseline;
            gap: 12px;
            margin-bottom: 8px;

            .point {
                color: #ff6b6b;
                font-size: 20px;
                font-weight: bold;

                @media (max-width: 768px) {
                    font-size: 18px;
                }
            }

            .market {
                color: #999;
                font-size: 14px;
                text-decoration: line-through;

                @media (max-width: 768px) {
                    font-size: 12px;
                }
            }
        }

        .goods-stock {
            font-size: 12px;
            color: #999;

            @media (max-width: 768px) {
                font-size: 11px;
            }
        }
    }
}

.skeleton {
    .skeleton-image {
        width: 100%;
        height: 200px;
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
    }

    .skeleton-content {
        padding: 16px;

        .skeleton-title {
            height: 20px;
            background: #f0f0f0;
            border-radius: 4px;
            margin-bottom: 12px;
        }

        .skeleton-price {
            height: 24px;
            width: 60%;
            background: #f0f0f0;
            border-radius: 4px;
        }
    }
}

@keyframes shimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
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
