<?php

namespace Igesef\NewsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NewsOfTheDay
 * @ORM\Table(name="news_of_the_day")
 * @ORM\Entity(repositoryClass="Igesef\NewsBundle\Entity\NewsOfTheDayRepository")
 */
class NewsOfTheDay
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var News
     *
     * @ORM\ManyToOne(targetEntity="News")
     * @ORM\JoinColumn(name="news_id", referencedColumnName="id", nullable=false)
     */
    private $news;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set news
     *
     * @param News $news
     *
     * @return NewsOfTheDay
     */
    public function setNews(News $news)
    {
        $this->news = $news;

        return $this;
    }

    /**
     * Get news
     *
     * @return News
     */
    public function getNews()
    {
        return $this->news;
    }
}
