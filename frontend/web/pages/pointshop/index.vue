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

            <div class="goods-grid" v-if="goodsList.length">
                <div class="goods-card" v-for="item in goodsList" :key="item.goods_id" @click="goDetail(item.goods_id)">
                    <div class="goods-image">
                        <img :src="item.goods_image" :alt="item.goods_name" />
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
            </div>

            <div class="empty" v-else-if="!loading">
                <p>暂无商品</p>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted, reactive } from 'vue'
import { useRouter } from 'vue-router'
import { getPointShopIndex, getPointGoodsList } from '@/api/pointshop'
import { useMemberStore } from '@/stores/member'

const router = useRouter()
const memberStore = useMemberStore()

const memberPoint = ref(0)
const categoryList = ref<any[]>([])
const categoryId = ref(0)
const goodsList = ref<any[]>([])
const loading = ref(false)

onMounted(() => {
    memberPoint.value = memberStore.info.point || 0
    loadIndex()
    loadGoods()
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
    loadGoods()
}

const loadGoods = async () => {
    loading.value = true
    try {
        const res = await getPointGoodsList({
            category_id: categoryId.value,
            page: 1,
            limit: 20
        })
        goodsList.value = res.data.data || []
    } catch (e) {
        console.error(e)
    } finally {
        loading.value = false
    }
}

const goDetail = (goods_id: number) => {
    router.push(`/pointshop/detail/${goods_id}`)
}

const goMyPoint = () => {
    router.push('/member/point')
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
        overflow: hidden;

        img {
            width: 100%;
            height: 100%;
            object-fit: cover;
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
            }

            .market {
                color: #999;
                font-size: 14px;
                text-decoration: line-through;
            }
        }

        .goods-stock {
            font-size: 12px;
            color: #999;
        }
    }
}

.empty {
    text-align: center;
    padding: 100px 0;
    color: #999;
    font-size: 16px;
}
</style>
