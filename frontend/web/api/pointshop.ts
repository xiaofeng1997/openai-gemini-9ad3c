import request from '@/utils/request'

export function getPointShopIndex() {
    return request.get('pointshop/index')
}

export function getPointGoodsList(params: Record<string, any>) {
    return request.get('pointshop/goods/list', { params })
}

export function getPointGoodsDetail(goods_id: number) {
    return request.get(`pointshop/goods/detail/${goods_id}`)
}

export function pointExchange(params: Record<string, any>) {
    return request.post('pointshop/exchange', params)
}

export function getPointOrderList(params: Record<string, any>) {
    return request.get('pointshop/order/list', { params })
}

export function getPointOrderDetail(order_id: number) {
    return request.get(`pointshop/order/detail/${order_id}`)
}

export function cancelPointOrder(order_id: number) {
    return request.put(`pointshop/order/cancel/${order_id}`)
}

export function confirmPointReceive(order_id: number) {
    return request.put(`pointshop/order/confirm/${order_id}`)
}
