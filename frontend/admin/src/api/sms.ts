import request from '@/utils/request'

/***************************************************** 短信配置管理 ****************************************************/

/**
 * 短信配置列表
 * @returns
 */
export function getSmsList() {
    return request.get('sms/config')
}

/**
 * 短信配置详情
 * @param sms_type
 * @returns
 */
export function getSmsInfo(sms_type: string) {
    return request.get(`sms/config/${ sms_type }`)
}

/**
 * 短信配置修改
 * @param params
 */
export function editSms(params: Record<string, any>) {
    return request.put(`sms/config/${ params.sms_type }`, params, { showSuccessMessage: true })
}

/**
 * 短信发送记录
 * @param params
 */
export function getSmsLog(params: Record<string, any>) {
    return request.get(`sms/log`, { params })
}

/***************************************************** 牛云短信管理 ****************************************************/

/**
 * 获取当前登录子账号
 */
export function getAccountIsLogin() {
    return request.get(`sms/niusms/config`)
}

/**
 * 登录子账号
 * @param params
 */
export function loginAccount(params: Record<string, any>) {
    return request.post(`sms/niusms/account/login`, params, { showSuccessMessage: true })
}

/**
 * 注册子账号
 * @param params
 */
export function registerAccount(params: Record<string, any>) {
    return request.post(`sms/niusms/account/register`, params, { showSuccessMessage: true })
}

/**
 * 获取当前登录子账号信息
 * @param username
 */
export function getAccountInfo(username: string) {
    return request.get(`sms/niusms/account/info/${username}`)
}

/**
 * 获取签名列表
 * @param username
 * @param params
 */
export function getSignList(username: string, params: Record<string, any>) {
    return request.get(`sms/niusms/sign/list/${username}`, { params })
}

/**
 * 添加签名
 * @param username
 * @param params
 */
export function addSign(username: string, params: Record<string, any>) {
    return request.post(`sms/niusms/sign/report/${username}`, params, { showSuccessMessage: true });
}

/**
 * 删除签名
 * @param username
 * @param params
 */
export function deleteSign(username: string, params: Record<string, any>) {
    return request.post(`sms/niusms/sign/delete/${username}`, params, { showSuccessMessage: true });
}

/**
 * 更新子账号信息
 * @param username
 * @param params
 */
export function editAccount(username: string, params: Record<string, any>) {
  return request.post(`sms/niusms/account/edit/${username}`, params, { showSuccessMessage: true });
}

/**
 * 获取充值列表
 * @param username
 * @param params
 */
export function getSmsOrdersList(username: string, params: Record<string, any>) {
    return request.get(`sms/niusms/order/list/${username}`, { params })
}

/**
 * 获取套餐列表
 */
export function getSmsPackagesList() {
    return request.get(`sms/niusms/packages`)
}

/**
 * 获取图像验证码
 */
export function getSmsCaptcha() {
    return request.get(`sms/niusms/captcha`)
}

/**
 * 发送验证码
 * @param params
 */
export function getSmsSend(params: Record<string, any>) {
    return request.post(`sms/niusms/send`, params, { showSuccessMessage: true })
}

/**
 * 添加签名配置项
 */
export function getSmsSignConfig() {
    return request.get(`sms/niusms/sign/report/config`)
}

/**
 * 充值下单
 * @param username
 * @param params
 */
export function smsOrderCreate(username: string, params: Record<string, any>) {
    return request.post(`sms/niusms/order/create/${username}`, params)
}

/**
 * 获取支付信息
 * @param username
 * @param params
 */
export function getOrderPayInfo(username: string, params: Record<string, any>) {
    return request.get(`sms/niusms/order/pay/${username}`, { params })
}

/**
 * 获取订单详情
 * @param username
 * @param params
 */
export function getOrderInfo(username: string, params: Record<string, any>) {
    return request.get(`sms/niusms/order/info/${username}`, { params })
}

/**
 * 获取支付状态
 * @param username
 * @param params
 */
export function getOrderPayStatus(username: string, params: Record<string, any>) {
    return request.get(`sms/niusms/order/status/${username}`, { params })
}

/**
 * 计算金额
 * @param username
 * @param params
 */
export function calculateOrderPay(username: string, params: Record<string, any>) {
    return request.post(`sms/niusms/order/calculate/${username}`, params)
}

/**
 * 启用牛云短信
 * @param params
 */
export function enableNiusms(params: Record<string, any>) {
    return request.put(`sms/niusms/enable`, params, { showSuccessMessage: true })
}

/**
 * 重置密码
 * @param username
 * @param params
 */
export function resetPassword(username: string, params: Record<string, any>) {
    return request.post(`sms/niusms/account/reset/password/${username}`, params, { showSuccessMessage: true })
}

/***************************************************** 短信模板管理 ****************************************************/

/**
 * 短信模板列表
 * @returns
 */
export function getSmsNoticeList() {
    return request.get('sms/notice')
}

/**
 * 短信模板详情
 * @param key
 * @returns
 */
export function getSmsNoticeInfo(key: string) {
    return request.get(`sms/notice/${key}`)
}

/**
 * 短信模板编辑
 * @param params
 * @returns
 */
export function editSmsNotice(params: Record<string, any>) {
    return request.post(`sms/notice/edit`, params, { showSuccessMessage: true })
}

/**
 * 短信模板状态修改
 * @param params
 * @returns
 */
export function editSmsNoticeStatus(params: Record<string, any>) {
    return request.post(`sms/notice/editstatus`, params, { showSuccessMessage: true })
}
