import { useEffect, useState } from 'react';

export function Preloader() {
    const [isVisible, setIsVisible] = useState(true);

    useEffect(() => {
        // Hide preloader when page is fully loaded
        const hidePreloader = () => {
            setTimeout(() => {
                setIsVisible(false);
                // Remove from DOM after fade out
                setTimeout(() => {
                    const preloaderRoot = document.getElementById('preloader-root');
                    if (preloaderRoot) {
                        preloaderRoot.style.display = 'none';
                    }
                }, 500);
            }, 300); // Small delay to ensure smooth transition
        };

        // Check if page is already loaded
        if (document.readyState === 'complete') {
            // Wait a bit to ensure the bloom animation plays
            setTimeout(() => {
                hidePreloader();
            }, 1000);
        } else {
            const handleLoad = () => {
                hidePreloader();
            };

            window.addEventListener('load', handleLoad);

            // Fallback: hide after minimum display time
            const minDisplayTime = setTimeout(() => {
                if (document.readyState === 'complete') {
                    hidePreloader();
                }
            }, 2000);

            return () => {
                window.removeEventListener('load', handleLoad);
                clearTimeout(minDisplayTime);
            };
        }
    }, []);

    if (!isVisible) {
        return null;
    }

    return (
        <div
            className="fixed inset-0 z-[9999] flex items-center justify-center bg-white dark:bg-gray-950 transition-opacity duration-500"
            style={{
                opacity: isVisible ? 1 : 0,
                pointerEvents: isVisible ? 'auto' : 'none',
            }}
        >
            <style>{`
                @keyframes bloomPetal {
                    0% {
                        transform: scale(0) rotate(0deg);
                        opacity: 0;
                    }
                    60% {
                        opacity: 1;
                    }
                    100% {
                        transform: scale(1) rotate(360deg);
                        opacity: 1;
                    }
                }

                @keyframes bloomInner {
                    0% {
                        transform: scale(0);
                        opacity: 0;
                    }
                    40% {
                        opacity: 0.6;
                    }
                    100% {
                        transform: scale(1);
                        opacity: 1;
                    }
                }

                @keyframes bloomCenter {
                    0% {
                        transform: scale(0);
                        opacity: 0;
                    }
                    50% {
                        opacity: 0.8;
                    }
                    100% {
                        transform: scale(1);
                        opacity: 1;
                    }
                }

                @keyframes float {
                    0%, 100% {
                        transform: translateY(0);
                    }
                    50% {
                        transform: translateY(-8px);
                    }
                }

                @keyframes fadeIn {
                    from {
                        opacity: 0;
                        transform: translateY(10px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                .rose-container {
                    animation: float 3s ease-in-out infinite;
                    transform-origin: center center;
                }

                .petal-outer {
                    animation: bloomPetal 2.5s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
                    transform-origin: 60px 60px;
                    opacity: 0;
                }

                .petal-inner {
                    animation: bloomInner 2s cubic-bezier(0.34, 1.56, 0.64, 1) 0.8s forwards;
                    transform-origin: 60px 60px;
                    opacity: 0;
                }

                .petal-center {
                    animation: bloomCenter 1.5s cubic-bezier(0.34, 1.56, 0.64, 1) 1.5s forwards;
                    transform-origin: 60px 60px;
                    opacity: 0;
                }

                .preloader-text {
                    animation: fadeIn 1s ease-out 2s both;
                    font-family: 'Alexandria', sans-serif;
                }
            `}</style>

            <div className="flex flex-col items-center justify-center">
                {/* Damask Rose SVG - Realistic Blooming */}
                <svg
                    className="rose-container"
                    width="200"
                    height="200"
                    viewBox="0 0 120 120"
                    xmlns="http://www.w3.org/2000/svg"
                    style={{ filter: 'drop-shadow(0 4px 12px rgba(231, 33, 119, 0.25))' }}
                >
                    {/* Outer Layer - 8 Large Petals */}
                    <path
                        className="petal-outer"
                        d="M 60 15 Q 70 25 78 35 Q 85 45 82 52 Q 79 59 72 63 Q 65 67 58 65 Q 51 63 46 56 Q 41 49 44 40 Q 47 31 55 25 Q 60 20 60 15 Z"
                        fill="#e72177"
                        style={{ animationDelay: '0s' }}
                    />
                    <path
                        className="petal-outer"
                        d="M 60 15 Q 70 25 78 35 Q 85 45 82 52 Q 79 59 72 63 Q 65 67 58 65 Q 51 63 46 56 Q 41 49 44 40 Q 47 31 55 25 Q 60 20 60 15 Z"
                        fill="#e72177"
                        transform="rotate(45 60 60)"
                        style={{ animationDelay: '0.1s' }}
                    />
                    <path
                        className="petal-outer"
                        d="M 60 15 Q 70 25 78 35 Q 85 45 82 52 Q 79 59 72 63 Q 65 67 58 65 Q 51 63 46 56 Q 41 49 44 40 Q 47 31 55 25 Q 60 20 60 15 Z"
                        fill="#e72177"
                        transform="rotate(90 60 60)"
                        style={{ animationDelay: '0.2s' }}
                    />
                    <path
                        className="petal-outer"
                        d="M 60 15 Q 70 25 78 35 Q 85 45 82 52 Q 79 59 72 63 Q 65 67 58 65 Q 51 63 46 56 Q 41 49 44 40 Q 47 31 55 25 Q 60 20 60 15 Z"
                        fill="#e72177"
                        transform="rotate(135 60 60)"
                        style={{ animationDelay: '0.3s' }}
                    />
                    <path
                        className="petal-outer"
                        d="M 60 15 Q 70 25 78 35 Q 85 45 82 52 Q 79 59 72 63 Q 65 67 58 65 Q 51 63 46 56 Q 41 49 44 40 Q 47 31 55 25 Q 60 20 60 15 Z"
                        fill="#e72177"
                        transform="rotate(180 60 60)"
                        style={{ animationDelay: '0.4s' }}
                    />
                    <path
                        className="petal-outer"
                        d="M 60 15 Q 70 25 78 35 Q 85 45 82 52 Q 79 59 72 63 Q 65 67 58 65 Q 51 63 46 56 Q 41 49 44 40 Q 47 31 55 25 Q 60 20 60 15 Z"
                        fill="#e72177"
                        transform="rotate(225 60 60)"
                        style={{ animationDelay: '0.5s' }}
                    />
                    <path
                        className="petal-outer"
                        d="M 60 15 Q 70 25 78 35 Q 85 45 82 52 Q 79 59 72 63 Q 65 67 58 65 Q 51 63 46 56 Q 41 49 44 40 Q 47 31 55 25 Q 60 20 60 15 Z"
                        fill="#e72177"
                        transform="rotate(270 60 60)"
                        style={{ animationDelay: '0.6s' }}
                    />
                    <path
                        className="petal-outer"
                        d="M 60 15 Q 70 25 78 35 Q 85 45 82 52 Q 79 59 72 63 Q 65 67 58 65 Q 51 63 46 56 Q 41 49 44 40 Q 47 31 55 25 Q 60 20 60 15 Z"
                        fill="#e72177"
                        transform="rotate(315 60 60)"
                        style={{ animationDelay: '0.7s' }}
                    />

                    {/* Middle Layer - 5 Petals */}
                    <path
                        className="petal-inner"
                        d="M 60 38 Q 65 42 68 47 Q 71 52 69 56 Q 67 60 64 62 Q 61 64 58 62 Q 55 60 53 56 Q 51 52 54 47 Q 57 42 60 38 Z"
                        fill="#f5428d"
                        style={{ animationDelay: '1s' }}
                    />
                    <path
                        className="petal-inner"
                        d="M 60 38 Q 65 42 68 47 Q 71 52 69 56 Q 67 60 64 62 Q 61 64 58 62 Q 55 60 53 56 Q 51 52 54 47 Q 57 42 60 38 Z"
                        fill="#f5428d"
                        transform="rotate(72 60 60)"
                        style={{ animationDelay: '1.1s' }}
                    />
                    <path
                        className="petal-inner"
                        d="M 60 38 Q 65 42 68 47 Q 71 52 69 56 Q 67 60 64 62 Q 61 64 58 62 Q 55 60 53 56 Q 51 52 54 47 Q 57 42 60 38 Z"
                        fill="#f5428d"
                        transform="rotate(144 60 60)"
                        style={{ animationDelay: '1.2s' }}
                    />
                    <path
                        className="petal-inner"
                        d="M 60 38 Q 65 42 68 47 Q 71 52 69 56 Q 67 60 64 62 Q 61 64 58 62 Q 55 60 53 56 Q 51 52 54 47 Q 57 42 60 38 Z"
                        fill="#f5428d"
                        transform="rotate(216 60 60)"
                        style={{ animationDelay: '1.3s' }}
                    />
                    <path
                        className="petal-inner"
                        d="M 60 38 Q 65 42 68 47 Q 71 52 69 56 Q 67 60 64 62 Q 61 64 58 62 Q 55 60 53 56 Q 51 52 54 47 Q 57 42 60 38 Z"
                        fill="#f5428d"
                        transform="rotate(288 60 60)"
                        style={{ animationDelay: '1.4s' }}
                    />

                    {/* Inner Layer - 3 Small Petals (Center) */}
                    <path
                        className="petal-center"
                        d="M 60 50 Q 61.5 52 62 54 Q 62.5 56 62 57 Q 61.5 58 61 58.5 Q 60.5 59 60 58.5 Q 59.5 58 59 57 Q 58.5 56 59 54 Q 59.5 52 60 50 Z"
                        fill="#862b90"
                        style={{ animationDelay: '1.6s' }}
                    />
                    <path
                        className="petal-center"
                        d="M 60 50 Q 61.5 52 62 54 Q 62.5 56 62 57 Q 61.5 58 61 58.5 Q 60.5 59 60 58.5 Q 59.5 58 59 57 Q 58.5 56 59 54 Q 59.5 52 60 50 Z"
                        fill="#862b90"
                        transform="rotate(120 60 60)"
                        style={{ animationDelay: '1.7s' }}
                    />
                    <path
                        className="petal-center"
                        d="M 60 50 Q 61.5 52 62 54 Q 62.5 56 62 57 Q 61.5 58 61 58.5 Q 60.5 59 60 58.5 Q 59.5 58 59 57 Q 58.5 56 59 54 Q 59.5 52 60 50 Z"
                        fill="#862b90"
                        transform="rotate(240 60 60)"
                        style={{ animationDelay: '1.8s' }}
                    />

                    {/* Rose Center (Stamen) */}
                    <circle
                        className="petal-center"
                        cx="60"
                        cy="60"
                        r="5"
                        fill="#c2b582"
                        style={{ animationDelay: '2s' }}
                    />
                </svg>

                {/* Loading Text */}
                <div
                    className="preloader-text mt-8 text-xl font-light"
                    style={{
                        color: '#e72177',
                        letterSpacing: '0.1em',
                    }}
                >
                    RosaCare
                </div>
            </div>
        </div>
    );
}
