import '../App.less';
import { HungryGauge } from "../HungryGauge/HungryGauge";
import { Card, Flex } from 'antd';
import opalLogo from '../../assets/opal-logo-blanc-long.png';
import antdLogo from '../../assets/ant-design.png';
import dockerLogo from '../../assets/docker.png';
import doctrineLogo from '../../assets/doctrine.svg';
import fontAwesomeLogo from '../../assets/font-awesome.png';
import lodashLogo from '../../assets/lodash.svg';
import postgresqlLogo from '../../assets/postgresql.png';
import reactRouterDomLogo from '../../assets/react-router-dom.png';
import reactLogo from '../../assets/react.png';
import symfonyLogo from '../../assets/symfony.png';

const Introduction = () => {
  return (    
  <>
    <div>
      <a href="https://opalsolutions.be/fr/" target="_blank">
        <img src={opalLogo} className="logo" alt="Opal Solutions logo" />
      </a>
    </div>
    <h1 className="title">Luncheo</h1>
    <div style={{ width: "100%" }}>
      <Flex
        vertical
        align='center'
      > 
        <Card 
          title={<h3>Introduction</h3>}
          bordered={false}
          className="card introduction-card"
        >
          <p>
            L’entreprise Opal Solutions rencontre des difficultés pour commander les sandwichs nécessaires pour nourrir ces employés affamés.
            Les pertes de commande, les mauvaises distributions de sandwichs et les interminables débats sur quel est le meilleur sandwich du “Time to Lunch” sont le quotidien de l’entreprise.
            Cela génère de l’insatisfaction et des pertes de temps considérable pour celle-ci. 
          </p>
          <p>
            Afin de reprendre la main sur sa gestion des sandwichs, Opal Solutions aimerait développer une plateforme permettant à ses employés de passer des commandes, d’indiquer les jours où chacun à besoin d’un sandwich, ainsi que d’avoir accès à un historique des consommations de chacun de ses employés.
          </p>
          <p>
            Ci-dessous tu trouveras la liste des outils mise à disposition pour la réalisation de ce projet
          </p>
        </Card>
        <Card 
          bordered={false}
          className="card group-card"
        >
          <h3>Frontend</h3>
        </Card>
        <Flex>
          <Card 
            title={<h4>React 18</h4>}
            bordered={false}
            className="card sub-group-card"
            onClick={() => window.open('https://fr.react.dev/learn', '_blank')}
          >
            <img src={reactLogo} className="card-logo" alt="React logo" />
          </Card>
          <Card 
            title={<h4>Antd 5</h4>}
            bordered={false}
            className="card sub-group-card antd-card"
            onClick={() => window.open('https://ant.design/components/overview/', '_blank')}
          >
            <img src={antdLogo} className="card-logo" alt="Antd logo" />
          </Card>
        </Flex>
        <Flex>
          <Card 
            title={<h4>Font Awesome 6</h4>}
            bordered={false}
            className="card sub-group-card"
            onClick={() => window.open('https://fontawesome.com/icons', '_blank')}
          >
            <img src={fontAwesomeLogo} className="card-logo" alt="Font Awesome logo" />
          </Card>
          <Card 
            title={<h4>Loadash</h4>}
            bordered={false}
            className="card sub-group-card"
            onClick={() => window.open('https://lodash.com/docs/4.17.15', '_blank')}
          >
            <img src={lodashLogo} className="card-logo" alt="Loadash logo" />
          </Card>
        </Flex>
        <Flex>
          <Card 
            title={<h4>React router</h4>}
            bordered={false}
            className="card sub-group-card"
            onClick={() => window.open('https://reactrouter.com/en/main/start/tutorial', '_blank')}
          >
            <img src={reactRouterDomLogo} className="card-logo" alt="React router dom logo" />
          </Card>
        </Flex>
        <Card 
          bordered={false}
          className="card group-card"
        >
          <h3>Backend</h3>
        </Card>
        <Flex>
          <Card 
            title={<h4>Symfony 7</h4>}
            bordered={false}
            className="card sub-group-card"
            onClick={() => window.open('https://symfony.com/doc/current/index.html', '_blank')}
          >
            <img src={symfonyLogo} className="card-logo" alt="Symfony logo" />
          </Card>
          <Card 
            title={<h4>Doctrine 3</h4>}
            bordered={false}
            className="card sub-group-card"
            onClick={() => window.open('https://www.doctrine-project.org/projects/doctrine-orm/en/3.3/tutorials/getting-started.html#getting-started-with-doctrine', '_blank')}
          >
            <img src={doctrineLogo} className="card-logo" alt="Doctrine logo" />
          </Card>
        </Flex>
        <Flex>
          <Card 
            title={<h4>PostgreSQL 16</h4>}
            bordered={false}
            className="card sub-group-card"
            onClick={() => window.open('https://www.postgresql.org/docs/16/index.html', '_blank')}
          >
            <img src={postgresqlLogo} className="card-logo" alt="Postgresql logo" />
          </Card>
          <Card 
            title={<h4>Docker</h4>}
            bordered={false}
            className="card sub-group-card"
            onClick={() => window.open('https://docs.docker.com/engine/install/ubuntu/', '_blank')}
          >
            <img src={dockerLogo} className="card-logo" alt="Docker logo" />
          </Card>
        </Flex>
      </Flex>
    </div>
    <HungryGauge />
  </>
  );
}

export default Introduction;