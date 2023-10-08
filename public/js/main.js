const url = window.location.origin
const pusherKey = '3ce7dfc6d3fab8ba50cc';

// remove alert after 3 seconds if any
const alert = document.querySelector('.alert')
if (alert !== null) {
    setTimeout(() => {
        document.querySelector('.alert').remove()
    }, 3000)
}

// Enable pusher logging - don't include this in production
Pusher.logToConsole = true
    
const pusher = new Pusher(pusherKey, {
  cluster: 'ap1'
})

const channel = pusher.subscribe('upload-csv');
channel.bind('csv.imported', function (data) {
    loadData()
})

loadData()

/**
 * Load data from log imports table
 */
function loadData() {
    fetch(url + '/data')
        .then(response => response.json())
        .then(data => {
            const table = document.querySelector('.table.log-imports tbody')
            let content = ''

            if (data.length !== 0) {
                data.forEach(({
                    file_name,
                    file_path,
                    time,
                    status,
                    status_color,
                    progress
                }, key) => {
                    content += `
                        <tr>
                            <th scope="row" class="text-center">${key+1}</th>
                            <td>${time}</td>
                            <td>
                                <a href="${file_path}" target="_blank" class="text-dark">${file_name}</a>
                            </td>
                            <td class="text-center">
                                <span class="badge text-bg-${status_color}" style="min-width: 80px">${status}</span>
                            </td>
                            <td class="text-center">
                                <div class="progress mt-1" role="progressbar" aria-label="Basic example" aria-valuenow="${progress}" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar bg-${status_color}" style="width: ${progress}%">${progress}%</div>
                                </div>
                            </td>
                        </tr>
                    `
                })
            } else {
                content += `
                    <tr>
                        <td colspan="5" class="text-center">Data is empty.</td>
                    </tr>
                `
            }

            table.innerHTML = content
        })
        .catch(error => {
            console.error('Log uploads error:', error)
        })
}
