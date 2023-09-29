const shortDesc = document.querySelector('#product-short-description')
shortDesc.innerHTML = ""

const productTitle = document.querySelector('#product-title')
productTitle.textContent = ""

const productFeatImg = document.querySelector('#main-product-pic')
productFeatImg.src = ''


const fetchUrl = 'https://dumatos-equipement.fr/wp-json/wp/v2/product/15478'
const fetchMediasUrl = 'https://dumatos-equipement.fr/wp-json/wp/v2/media/'


const datas = fetch(fetchUrl).then((response => response.json())).then((data =>
    renderContent(data)))


function renderContent(datas) {
    console.log(datas)
    shortDesc.innerHTML = datas.excerpt.rendered
    productTitle.textContent = datas.title.rendered
    const fetchByImgId = fetchMediasUrl + datas.featured_media
    console.log(datas.featured_media)
    const medias = fetch(fetchByImgId).then((response => response.json())).then((mediasDatas =>
        renderMedias(mediasDatas)))


}

function renderMedias(datas) {
    console.log(datas)
    productFeatImg.src = datas.source_url
    productFeatImg.alt = datas.alt_text
}
