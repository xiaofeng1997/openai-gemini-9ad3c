import request from '@/utils/request'

export function getPointShopIndex() {
    return request.get('pointshop/index')
}

export function getPointGoodsList(params: Record<string, any>) {
    return request.get('pointshop/goodsList', { params })
}

export function getPointGoodsDetail(goods_id: number) {
    return request.get(`pointshop/goodsDetail/${goods_id}`)
}

export function pointExchange(params: Record<string, any>) {
    return request.post('pointshop/exchange', params)
}

export function getPointOrderList(params: Record<string, any>) {
    return request.get('pointshop/orderList', { params })
}

export function getPointOrderDetail(order_id: number) {
    return request.get(`pointshop/orderDetail/${order_id}`)
}

export function cancelPointOrder(order_id: number) {
    return request.put(`pointshop/cancelOrder/${order_id}`)
}

export function confirmPointReceive(order_id: number) {
    return request.put(`pointshop/confirmReceive/${order_id}`)
}
