import request from '@/utils/request'

/**
 * 获取商品列表
 * @param params
 * @returns
 */
export function getPointGoodsList(params: Record<string, any>) {
    return request.get('pointshop/goods/lists', { params })
}

/**
 * 获取商品详情
 * @param goods_id
 * @returns
 */
export function getPointGoodsInfo(goods_id: number) {
    return request.get(`pointshop/goods/info/${goods_id}`)
}

/**
 * 添加商品
 * @param params
 * @returns
 */
export function addPointGoods(params: Record<string, any>) {
    return request.post('pointshop/goods/add', params, { showSuccessMessage: true })
}

/**
 * 编辑商品
 * @param goods_id
 * @param params
 * @returns
 */
export function editPointGoods(goods_id: number, params: Record<string, any>) {
    return request.put(`pointshop/goods/edit/${goods_id}`, params, { showSuccessMessage: true })
}

/**
 * 删除商品
 * @param goods_id
 * @returns
 */
export function deletePointGoods(goods_id: number) {
    return request.delete(`pointshop/goods/del/${goods_id}`, { showSuccessMessage: true })
}

/**
 * 设置商品状态
 * @param params
 * @returns
 */
export function setPointGoodsStatus(params: Record<string, any>) {
    return request.put('pointshop/goods/setStatus', params, { showSuccessMessage: true })
}

/**
 * 获取商品分类
 * @returns
 */
export function getPointCategory() {
    return request.get('pointshop/goods/getCategory')
}

/**
 * 获取分类列表
 * @returns
 */
export function getPointCategoryList() {
    return request.get('pointshop/category/lists')
}

/**
 * 获取分类详情
 * @param category_id
 * @returns
 */
export function getPointCategoryInfo(category_id: number) {
    return request.get(`pointshop/category/info/${category_id}`)
}

/**
 * 添加分类
 * @param params
 * @returns
 */
export function addPointCategory(params: Record<string, any>) {
    return request.post('pointshop/category/add', params, { showSuccessMessage: true })
}

/**
 * 编辑分类
 * @param category_id
 * @param params
 * @returns
 */
export function editPointCategory(category_id: number, params: Record<string, any>) {
    return request.put(`pointshop/category/edit/${category_id}`, params, { showSuccessMessage: true })
}

/**
 * 删除分类
 * @param category_id
 * @returns
 */
export function deletePointCategory(category_id: number) {
    return request.delete(`pointshop/category/del/${category_id}`, { showSuccessMessage: true })
}

/**
 * 获取订单列表
 * @param params
 * @returns
 */
export function getPointOrderList(params: Record<string, any>) {
    return request.get('pointshop/order/lists', { params })
}

/**
 * 获取订单详情
 * @param order_id
 * @returns
 */
export function getPointOrderInfo(order_id: number) {
    return request.get(`pointshop/order/info/${order_id}`)
}

/**
 * 订单发货
 * @param params
 * @returns
 */
export function deliverPointOrder(params: Record<string, any>) {
    return request.post('pointshop/order/deliver', params, { showSuccessMessage: true })
}

/**
 * 获取订单状态列表
 * @returns
 */
export function getPointOrderStatusList() {
    return request.get('pointshop/order/getStatusList')
}
