
function updateTime(sv) {
    let d = document.querySelector('#days');
    let h = document.querySelector('#hours');
    let m = document.querySelector('#minutes');
    let s = document.querySelector('#seconds');

    d.innerHTML = Math.floor((sv%2592000)/86400);
    h.innerHTML = Math.floor((sv%86400)/3600);
    m.innerHTML = Math.floor((sv%3600)/60);
    s.innerHTML = Math.floor(sv%60);
    // console.log(d);
}

let dataDPM = [];
let dataBEM = [];

let dpmCtx = document.querySelector('#hasilSuaraDpm')
var dpmChart = new Chart(dpmCtx, {
    type: 'bar',
    data: {
        labels: ['Grafik Suara DPM'],
        datasets: dataDPM
    },
});

let bemCtx = document.querySelector('#hasilSuaraBem')
var bemChart = new Chart(bemCtx, {
    type: 'bar',
    data: {
        labels: ['Grafik Suara BEM'],
        datasets: dataBEM
    },
});

updateChart();

setInterval(() => {
    updateChart();
}, 5000)

function updateChart() {
    let colors = [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
    ];
    let bColors = [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
    ];

    axios.get('/api/quickcount')
    .then(r => {

        let data = r.data.body;
        data.dpm.cadidates.forEach((v,i) => {
            dataDPM.push({
                label: v.nama,
                data: [v.voters],
                backgroundColor: colors[i],
                borderColor: bColors[i],
                borderWidth: 1
            });
        });

        dpmChart.update();
        data.bem.cadidates.forEach((v,i) => {
            dataBEM.push({
                label: v.nama,
                data: [v.voters],
                backgroundColor: colors[i],
                borderColor: bColors[i],
                borderWidth: 1
            });
        });

        setValue('.total_voters', data.voters);
        setValue('.hasVotesDPM', data.dpm.hasVotes);
        setValue('.hasVotesBEM', data.bem.hasVotes);
        setValue('.notVotesDPM', data.voters-data.dpm.hasVotes);
        setValue('.notVotesBEM', data.voters-data.bem.hasVotes);
        bemChart.update();
        dataDPM = [];
        dataBEM = [];
    })
}

function setValue(s,v) {
    document.querySelectorAll(s).forEach(el => {
        el.innerHTML = v;
    })
}