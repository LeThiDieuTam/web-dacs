import XoaDiuNoiDauDaCam from './image/XoaDiuNoiDauDaCam.jpg';

function History() { // Đặt tên component với chữ cái đầu tiên viết hoa
    const slides = [ // Sửa chính tả từ 'slide' thành 'slides'
        {
            title: "Day 1", // Sửa từ 'tittle' thành 'title'
            place: "NAYAPUL",
            color: "text-red-600",
            img: XoaDiuNoiDauDaCam,
        },
        {
            title: "Day 2",
            place: "NAYAPUL",
            color: "text-[#e9ab32]",
            img: XoaDiuNoiDauDaCam,
        },
        {
            title: "Day 3",
            place: "NAYAPUL",
            color: "text-[#598fe1]",
            img: XoaDiuNoiDauDaCam,
        },
    ];

    return (
        <div className="container bg-[#f2f2f2]">
            {slides.map((slide) => (
                <section className="h-screen flex" key={slide.title}>
                    <div className="w-[35%]"></div>
                    <div className="flex flex-col justify-center w-[30%]">
                        <h2 className={slide.color}>{slide.title}</h2>
                        <h1>{slide.place}</h1>
                    </div>
                    <div className="w-[35%]">
                        <div
                            style={{
                                backgroundImage: `url(${slide.img})`, // Sử dụng backgroundImage đúng cách
                                backgroundPosition: "center",
                                backgroundSize: "cover",
                                height: '100%', // Đặt chiều cao cho div chứa ảnh
                            }}
                        />
                    </div>
                </section>
            ))}
        </div>
    );
}

export default History;
