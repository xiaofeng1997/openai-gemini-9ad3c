# 修复乱码脚本
$files = Get-ChildItem -Path "g:\gitbook\niucloud-lite\admin\src" -Recurse -File -Include *.vue,*.ts,*.js

$replacements = @{
    "验证手机号格�?" = "验证手机号格式"
    "隐藏拨打电�?" = "隐藏拨打电话"
    "动态组件名�?" = "动态组件名称"
    "检测登�?" = "检测登录"
    "面包屑导�?" = "面包屑导航"
    "跳转去预�?" = "跳转去预览"
    "存储所有特殊菜单的name" = "存储所有特殊菜单的name"
    "让二级菜单默认展开" = "让二级菜单默认展开"
    "统一处理跳转逻辑" = "统一处理跳转逻辑"
    "检查目标路由是否在特殊菜单列表中?" = "检查目标路由是否在特殊菜单列表中"
    "核心逻辑：如果不在特殊菜单中，就删除activeAppKey" = "核心逻辑：如果不在特殊菜单中，就删除activeAppKey"
    "执行跳转" = "执行跳转"
    "处理菜单选择事件" = "处理菜单选择事件"
    "处理一级菜单选择事件" = "处理一级菜单选择事件"
    "修改密码 --- start" = "修改密码 --- start"
    "提交信息" = "提交信息"
    "表单验证规则" = "表单验证规则"
    "监听标签页面切换" = "监听标签页面切换"
    "监听窗体宽度变化" = "监听窗体宽度变化"
    "刷新路由" = "刷新路由"
    "指定需要忽略的自定义链接，例如：['DIY_MAKE_PHONE_CALL']，表示隐藏拨打电�?" = "指定需要忽略的自定义链接，例如：['DIY_MAKE_PHONE_CALL']，表示隐藏拨打电话"
}

$count = 0
foreach ($file in $files) {
    $content = Get-Content -Path $file.FullName -Raw -Encoding UTF8
    $modified = $false
    
    foreach ($key in $replacements.Keys) {
        if ($content -match [regex]::Escape($key)) {
            $content = $content -replace [regex]::Escape($key), $replacements[$key]
            $modified = $true
        }
    }
    
    if ($modified) {
        Set-Content -Path $file.FullName -Value $content -Encoding UTF8 -NoNewline
        Write-Host "Fixed: $($file.FullName)"
        $count++
    }
}

Write-Host "`nTotal files fixed: $count"
