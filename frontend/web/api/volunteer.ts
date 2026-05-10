import request from '@/utils/request'

export function getVolunteerIndex() {
    return request.get('volunteer/index')
}

export function getVolunteerCategory() {
    return request.get('volunteer/category')
}

export function getServiceLists(params: Record<string, any>) {
    return request.get('volunteer/service/lists', { params })
}

export function getServiceDetail(service_id: number) {
    return request.get(`volunteer/service/detail/${service_id}`)
}

export function getVolunteerProfile(volunteer_id: number) {
    return request.get(`volunteer/volunteer/profile/${volunteer_id}`)
}

export function applyVolunteer(params: Record<string, any>) {
    return request.post('volunteer/apply', params)
}

export function getMyVolunteer() {
    return request.get('volunteer/myVolunteer')
}

export function checkIsVolunteer() {
    return request.get('volunteer/isVolunteer')
}

export function publishService(params: Record<string, any>) {
    return request.post('volunteer/publishService', params)
}

export function getMyService() {
    return request.get('volunteer/myService')
}

export function editMyService(service_id: number, params: Record<string, any>) {
    return request.put(`volunteer/editService/${service_id}`, params)
}

export function createServiceOrder(params: Record<string, any>) {
    return request.post('volunteer/createOrder', params)
}

export function getServiceOrderLists(params: Record<string, any>) {
    return request.get('volunteer/order/lists', { params })
}

export function getMyServeOrderLists(params: Record<string, any>) {
    return request.get('volunteer/myServe/order/lists', { params })
}

export function getServiceOrderDetail(order_id: number) {
    return request.get(`volunteer/order/detail/${order_id}`)
}

export function cancelServiceOrder(order_id: number) {
    return request.put(`volunteer/cancelOrder/${order_id}`)
}

export function confirmServiceOrder(params: Record<string, any>) {
    return request.post('volunteer/confirmOrder', params)
}

export function startService(order_id: number) {
    return request.put(`volunteer/startService/${order_id}`)
}

export function finishService(order_id: number) {
    return request.put(`volunteer/finishService/${order_id}`)
}

export function createEvaluation(params: Record<string, any>) {
    return request.post('volunteer/createEvaluation', params)
}

export function replyEvaluation(params: Record<string, any>) {
    return request.post('volunteer/replyEvaluation', params)
}
