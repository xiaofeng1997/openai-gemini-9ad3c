import request from '@/utils/request'

/**
 * 获取积分商城首页数据
 */
export function getPointShopIndex() {
    return request.get('pointshop/index')
}

/**
 * 获取商品列表
 */
export function getPointGoodsList(params: Record<string, any>) {
    return request.get('pointshop/goods/list', { params })
}

/**
 * 获取商品详情
 */
export function getPointGoodsDetail(goods_id: number) {
    return request.get(`pointshop/goods/detail/${goods_id}`)
}

/**
 * 积分兑换
 */
export function pointExchange(params: Record<string, any>) {
    return request.post('pointshop/exchange', params)
}

/**
 * 获取订单列表
 */
export function getPointOrderList(params: Record<string, any>) {
    return request.get('pointshop/order/list', { params })
}

/**
 * 获取订单详情
 */
export function getPointOrderDetail(order_id: number) {
    return request.get(`pointshop/order/detail/${order_id}`)
}

/**
 * 取消订单
 */
export function cancelPointOrder(order_id: number) {
    return request.put(`pointshop/order/cancel/${order_id}`)
}

/**
 * 确认收货
 */
export function confirmPointReceive(order_id: number) {
    return request.put(`pointshop/order/confirm/${order_id}`)
}
