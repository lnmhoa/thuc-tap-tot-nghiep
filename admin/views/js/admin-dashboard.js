document.addEventListener('DOMContentLoaded', function() {
    if (typeof Chart === 'undefined') {
        console.error('Chart.js chưa được load!');
        return;
    }

    if (typeof chartDataFromPHP === 'undefined' || typeof totalStats === 'undefined') {
        console.error('Dữ liệu từ PHP chưa sẵn sáng!');
        return;
    }

    const months = chartDataFromPHP.map(item => item.month);
    const propertiesData = chartDataFromPHP.map(item => item.properties);
    const brokersData = chartDataFromPHP.map(item => item.brokers);
    const usersData = chartDataFromPHP.map(item => item.users);
    const newsData = chartDataFromPHP.map(item => item.news);
    const contactsData = chartDataFromPHP.map(item => item.contacts);

    const colors = {
        properties: {
            bg: 'rgba(52, 152, 219, 0.2)',
            border: 'rgba(52, 152, 219, 1)'
        },
        brokers: {
            bg: 'rgba(46, 204, 113, 0.2)',
            border: 'rgba(46, 204, 113, 1)'
        },
        users: {
            bg: 'rgba(243, 156, 18, 0.2)',
            border: 'rgba(243, 156, 18, 1)'
        },
        news: {
            bg: 'rgba(155, 89, 182, 0.2)',
            border: 'rgba(155, 89, 182, 1)'
        },
        contacts: {
            bg: 'rgba(231, 76, 60, 0.2)',
            border: 'rgba(231, 76, 60, 1)'
        }
    };

    const lineCtx = document.getElementById('adminLineChart');
    if (lineCtx) {
        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [
                    {
                        label: 'Bất động sản',
                        data: propertiesData,
                        backgroundColor: colors.properties.bg,
                        borderColor: colors.properties.border,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Môi giới',
                        data: brokersData,
                        backgroundColor: colors.brokers.bg,
                        borderColor: colors.brokers.border,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Người dùng',
                        data: usersData,
                        backgroundColor: colors.users.bg,
                        borderColor: colors.users.border,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Tin tức',
                        data: newsData,
                        backgroundColor: colors.news.bg,
                        borderColor: colors.news.border,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Liên hệ',
                        data: contactsData,
                        backgroundColor: colors.contacts.bg,
                        borderColor: colors.contacts.border,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: 'white',
                        bodyColor: 'white',
                        borderColor: 'rgba(255, 255, 255, 0.2)',
                        borderWidth: 1
                    }
                },
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Tháng'
                        },
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Số lượng'
                        },
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });
    }

    const barCtx = document.getElementById('adminBarChart');
    if (barCtx) {
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Bất động sản', 'Môi giới', 'Người dùng', 'Tin tức', 'Liên hệ'],
                datasets: [{
                    label: 'Tổng số lượng',
                    data: [
                        totalStats.properties,
                        totalStats.brokers,
                        totalStats.users,
                        totalStats.news,
                        totalStats.contacts
                    ],
                    backgroundColor: [
                        colors.properties.border,
                        colors.brokers.border,
                        colors.users.border,
                        colors.news.border,
                        colors.contacts.border
                    ],
                    borderColor: [
                        colors.properties.border,
                        colors.brokers.border,
                        colors.users.border,
                        colors.news.border,
                        colors.contacts.border
                    ],
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: 'white',
                        bodyColor: 'white',
                        borderColor: 'rgba(255, 255, 255, 0.2)',
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y.toLocaleString('vi-VN');
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        },
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('vi-VN');
                            }
                        }
                    }
                }
            }
        });
    }

    const pieCtx = document.getElementById('adminPieChart');
    if (pieCtx) {
        new Chart(pieCtx, {
            type: 'doughnut',
            data: {
                labels: ['Bất động sản', 'Môi giới', 'Người dùng', 'Tin tức', 'Liên hệ'],
                datasets: [{
                    data: [
                        totalStats.properties,
                        totalStats.brokers,
                        totalStats.users,
                        totalStats.news,
                        totalStats.contacts
                    ],
                    backgroundColor: [
                        colors.properties.border,
                        colors.brokers.border,
                        colors.users.border,
                        colors.news.border,
                        colors.contacts.border
                    ],
                    borderColor: '#fff',
                    borderWidth: 3,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: 'white',
                        bodyColor: 'white',
                        borderColor: 'rgba(255, 255, 255, 0.2)',
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return `${context.label}: ${context.parsed.toLocaleString('vi-VN')} (${percentage}%)`;
                            }
                        }
                    }
                },
                cutout: '50%'
            }
        });
    }

    console.log('Admin Dashboard Charts initialized successfully!');
});

function refreshDashboardCharts() {
    location.reload();
}