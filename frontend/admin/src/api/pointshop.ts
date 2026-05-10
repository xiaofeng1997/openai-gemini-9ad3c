import request from '@/utils/request'

export function getPointGoodsList(params: Record<string, any>) {
    return request.get('pointshop/goods/lists', { params })
}

export function getPointGoodsInfo(goods_id: number) {
    return request.get(`pointshop/goods/info/${goods_id}`)
}

export function addPointGoods(params: Record<string, any>) {
    return request.post('pointshop/goods/add', params, { showSuccessMessage: true })
}

export function editPointGoods(goods_id: number, params: Record<string, any>) {
    return request.put(`pointshop/goods/edit/${goods_id}`, params, { showSuccessMessage: true })
}

export function deletePointGoods(goods_id: number) {
    return request.delete(`pointshop/goods/del/${goods_id}`, { showSuccessMessage: true })
}

export function setPointGoodsStatus(params: Record<string, any>) {
    return request.put('pointshop/goods/setStatus', params, { showSuccessMessage: true })
}

export function getPointCategory() {
    return request.get('pointshop/goods/getCategory')
}

export function getPointCategoryList() {
    return request.get('pointshop/category/lists')
}

export function getPointCategoryInfo(category_id: number) {
    return request.get(`pointshop/category/info/${category_id}`)
}

export function addPointCategory(params: Record<string, any>) {
    return request.post('pointshop/category/add', params, { showSuccessMessage: true })
}

export function editPointCategory(category_id: number, params: Record<string, any>) {
    return request.put(`pointshop/category/edit/${category_id}`, params, { showSuccessMessage: true })
}

export function deletePointCategory(category_id: number) {
    return request.delete(`pointshop/category/del/${category_id}`, { showSuccessMessage: true })
}

export function getPointOrderList(params: Record<string, any>) {
    return request.get('pointshop/order/lists', { params })
}

export function getPointOrderInfo(order_id: number) {
    return request.get(`pointshop/order/info/${order_id}`)
}

export function deliverPointOrder(params: Record<string, any>) {
    return request.post('pointshop/order/deliver', params, { showSuccessMessage: true })
}

export function getPointOrderStatusList() {
    return request.get('pointshop/order/getStatusList')
}
