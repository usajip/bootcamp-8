 // 1. Data Produk (20 items)
const products = [
    { id: 1, name: "Smartphone X1", price: 4500000, desc: "Ponsel pintar dengan kamera 108MP.", cat: "Elektronik", img: "https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=500&auto=format&fit=crop" },
    { id: 2, name: "Kaos Polo Premium", price: 150000, desc: "Bahan katun sejuk dan nyaman dipakai.", cat: "Fashion", img: "https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500&auto=format&fit=crop" },
    { id: 3, name: "Blender Super", price: 350000, desc: "Pisau stainless steel tahan karat.", cat: "Rumah Tangga", img: "https://images.unsplash.com/photo-1570222100680-bccec22c9ee3?w=500&auto=format&fit=crop" },
    { id: 4, name: "Sepatu Lari Pro", price: 850000, desc: "Ringan dan bantalan empuk untuk lari jauh.", cat: "Olahraga", img: "https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500&auto=format&fit=crop" },
    { id: 5, name: "Laptop Ultrabook", price: 12000000, desc: "Tipis, ringan, dan performa kencang.", cat: "Elektronik", img: "https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=500&auto=format&fit=crop" },
    { id: 6, name: "Jaket Denim", price: 450000, desc: "Gaya klasik yang tidak pernah mati.", cat: "Fashion", img: "https://images.unsplash.com/photo-1576995853123-5a10305d93c0?w=500&auto=format&fit=crop" },
    { id: 7, name: "Set Pisau Dapur", price: 200000, desc: "Set isi 5 untuk segala kebutuhan masak.", cat: "Rumah Tangga", img: "https://images.unsplash.com/photo-1593618998160-e34014e67546?w=500&auto=format&fit=crop" },
    { id: 8, name: "Bola Basket", price: 300000, desc: "Ukuran standar kompetisi internasional.", cat: "Olahraga", img: "https://images.unsplash.com/photo-1519861531473-9200362f46b3?w=500&auto=format&fit=crop" },
    { id: 9, name: "Headset Gaming", price: 650000, desc: "Suara surround 7.1 dengan noise canceling.", cat: "Elektronik", img: "https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&auto=format&fit=crop" },
    { id: 10, name: "Dress Bunga", price: 250000, desc: "Cocok untuk acara santai maupun semi-formal.", cat: "Fashion", img: "https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?w=500&auto=format&fit=crop" },
    { id: 11, name: "Air Fryer 2L", price: 750000, desc: "Masak tanpa minyak lebih sehat.", cat: "Rumah Tangga", img: "https://images.unsplash.com/photo-1626071466175-796797e97a33?w=500&auto=format&fit=crop" },
    { id: 12, name: "Matras Yoga", price: 120000, desc: "Anti slip dan mudah dibersihkan.", cat: "Olahraga", img: "https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=500&auto=format&fit=crop" },
    { id: 13, name: "Smartwatch v3", price: 1200000, desc: "Pantau detak jantung dan kualitas tidur.", cat: "Elektronik", img: "https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&auto=format&fit=crop" },
    { id: 14, name: "Kacamata Hitam", price: 180000, desc: "Lensa polarized pelindung UV400.", cat: "Fashion", img: "https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=500&auto=format&fit=crop" },
    { id: 15, name: "Lampu Meja LED", price: 95000, desc: "Tingkat terang yang bisa diatur.", cat: "Rumah Tangga", img: "https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=500&auto=format&fit=crop" },
    { id: 16, name: "Raket Badminton", price: 400000, desc: "Frame karbon super ringan.", cat: "Olahraga", img: "https://images.unsplash.com/photo-1626225453262-216b618f121d?w=500&auto=format&fit=crop" },
    { id: 17, name: "Kamera Mirrorless", price: 8500000, desc: "Sensor APS-C dengan autofokus cepat.", cat: "Elektronik", img: "https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=500&auto=format&fit=crop" },
    { id: 18, name: "Celana Chino", price: 220000, desc: "Potongan slim fit yang modis.", cat: "Fashion", img: "https://images.unsplash.com/photo-1541099649105-f69ad21f3246?w=500&auto=format&fit=crop" },
    { id: 19, name: "Vacuum Cleaner", price: 550000, desc: "Daya hisap kuat untuk debu halus.", cat: "Rumah Tangga", img: "https://images.unsplash.com/photo-1558317374-067fb5f30001?w=500&auto=format&fit=crop" },
    { id: 20, name: "Tas Gym", price: 175000, desc: "Kapasitas besar dengan kompartemen sepatu.", cat: "Olahraga", img: "https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=500&auto=format&fit=crop" }
];

// State Global
let currentFilter = "all";
let searchQuery = "";

// DOM Elements
const productGrid = document.getElementById('productGrid');
const filterButtonsContainer = document.getElementById('filterButtons');
const searchInput = document.getElementById('searchInput');
const emptyState = document.getElementById('empty-state');

// Fungsi format mata uang
const formatRupiah = (number) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(number);
};

// 2. Render Produk
function renderProducts() {
    const filtered = products.filter(p => {
        const matchCategory = currentFilter === "all" || p.cat === currentFilter;
        const matchSearch = p.name.toLowerCase().includes(searchQuery.toLowerCase());
        return matchCategory && matchSearch;
    });

    productGrid.innerHTML = "";
    
    if (filtered.length === 0) {
        emptyState.style.display = "block";
    } else {
        emptyState.style.display = "none";
        filtered.forEach(p => {
            const card = `
                <div class="col">
                    <div class="card product-card">
                        <span class="category-badge">${p.cat}</span>
                        <img src="${p.img}" class="card-img-top product-img" alt="${p.name}" onerror="this.src='https://via.placeholder.com/300x200?text=No+Image'">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-truncate" title="${p.name}">${p.name}</h5>
                            <p class="card-text text-muted small flex-grow-1">${p.desc}</p>
                            <div class="mt-3">
                                <p class="price mb-2">${formatRupiah(p.price)}</p>
                                <button class="btn btn-outline-primary w-100 rounded-pill btn-sm">Lihat Detail</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            productGrid.innerHTML += card;
        });
    }
}

// 3. Generate Tombol Filter secara dinamis
function generateFilterButtons() {
    const categories = ["all", ...new Set(products.map(p => p.cat))];
    
    filterButtonsContainer.innerHTML = categories.map(cat => `
        <button class="btn btn-outline-primary btn-filter ${cat === 'all' ? 'active' : ''}" 
                data-category="${cat}">
            ${cat === 'all' ? 'Semua' : cat}
        </button>
    `).join('');

    // Event listener untuk tombol filter
    document.querySelectorAll('.btn-filter').forEach(btn => {
        btn.addEventListener('click', (e) => {
            document.querySelectorAll('.btn-filter').forEach(b => b.classList.remove('active', 'btn-primary'));
            document.querySelectorAll('.btn-filter').forEach(b => b.classList.add('btn-outline-primary'));
            
            btn.classList.remove('btn-outline-primary');
            btn.classList.add('active', 'btn-primary');
            
            currentFilter = btn.dataset.category;
            renderProducts();
        });
    });
}

// 4. Fitur Search
searchInput.addEventListener('input', (e) => {
    searchQuery = e.target.value;
    renderProducts();
});

// Inisialisasi awal
window.onload = () => {
    generateFilterButtons();
    renderProducts();
};