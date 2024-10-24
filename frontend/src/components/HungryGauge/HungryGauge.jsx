import { Button, Progress } from "antd"
import { useEffect, useMemo, useState } from "react"
import sandwichLogo from '../../assets/HungryGaugeLogos/sandwich.png'
import zeroLogo from '../../assets/HungryGaugeLogos/0_percent.png'
import oneLogo from '../../assets/HungryGaugeLogos/20_percent.png'
import twoLogo from '../../assets/HungryGaugeLogos/40_percent.png'
import threeLogo from '../../assets/HungryGaugeLogos/60_percent.png'
import fourLogo from '../../assets/HungryGaugeLogos/80_percent.png'
import fiveLogo from '../../assets/HungryGaugeLogos/100_percent.png'

export const HungryGauge = () => {
  const konamiCode = useMemo(() => [
    'ArrowUp', 'ArrowUp', 'ArrowDown', 'ArrowDown',
    'ArrowLeft', 'ArrowRight', 'ArrowLeft', 'ArrowRight',
    'b', 'a', 'Enter'
  ], []);

  const [percent, setPercent] = useState(0)
  const [isAnimating, setIsAnimating] = useState(false);
  const [displayGauge, setDisplayGauge] = useState(false);
  const [inputSequence, setInputSequence] = useState([]);

  useEffect(() => {
    const handleKeyDown = (e) => {
      setInputSequence((prevSequence) => {
        const newSequence = [...prevSequence, e.key].slice(-konamiCode.length);
        return newSequence;
      });
    };

    window.addEventListener('keydown', handleKeyDown);

    return () => {
      window.removeEventListener('keydown', handleKeyDown);
    };
  }, [konamiCode.length]);

  useEffect(() => {
    if (inputSequence.join(' ') === konamiCode.join(' ')) {
      setDisplayGauge(true);
    }
  }, [inputSequence, konamiCode]);

  const smileyLogo = useMemo(() => {
    if (percent < 20) return zeroLogo;
    if (percent < 40) return oneLogo;
    if (percent < 60) return twoLogo;
    if (percent < 80) return threeLogo;
    if (percent < 100) return fourLogo;
    else return fiveLogo;
  }, [percent]);

  const increaseProgress = () => {
    setIsAnimating(true);
    setPercent(prev => (prev < 100 ? prev + 10 : prev >= 100 ? 0 : prev));
    setTimeout(() => {
      setIsAnimating(false);
    }, 1000);
  };

  return (
    displayGauge && (
      <>
        <div style={{ position: "fixed", right: "-10vh", top: "450px" }}>
          <div style={{ position: "fixed", right: "17vh", top: "130px" }}>
            <img style={{ top: "-10px", height: '100px' }} src={smileyLogo} className="card-logo" alt="Postgresql logo" />
          </div>
          <Progress
            size={[500, 100]}
            percent={percent}
            strokeLinecap="square"
            strokeColor="#1890ff"
            showInfo={false}
            format={percent => `${percent}%`}
            style={{ transform: 'rotate(-90deg)' }}
          />
          <Button type="primary" style={{ top: "240px" }} onClick={increaseProgress}> 
            {`J'ai faim !`}
          </Button>
          <div
            style={{
              position: "fixed",
              right: "17vh",
              top: "430px",
              fontSize: '0px',
              transition: 'transform 1s ease, opacity 1s ease',
              transform: isAnimating ? 'scale(1.5)' : 'scale(0)',
              opacity: isAnimating ? 1 : 0
            }}
          >
            <img style={{ height: '100px' }} src={sandwichLogo} className="card-logo" alt="Postgresql logo" />
          </div>
        </div>
      </>
    )
  )
}
